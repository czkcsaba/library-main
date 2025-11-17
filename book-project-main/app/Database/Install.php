<?php

namespace App\Database;

use App\Models\RoomModel;
use App\Models\GuestModel;
use App\Views\Display;
use App\Database\Database;
use Exception;

class Install extends Database
{

    public function __construct($config){
        parent::__construct($config);
        if (!$this::dbExists()){
            $this->createDatabase();
            $this->createTables();
            $this->fillTables();
        }
        $this->setGlobalMaxAllowedPacket();
    }

    private function dbExists(): bool
    {
        try {
            $mysqli = $this->getConn('mysql');
            if (!$mysqli) {
                return false;
            }

            $query = sprintf("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '%s';", self::DEFAULT_CONFIG['database']);
            $result = $mysqli->query($query);

            if (!$result) {
                throw new Exception('Lekérdezési hiba: ' . $mysqli->error);
            }
            $exists = $result->num_rows > 0;

            return $exists;

        }
        catch (Exception $e) {
            Display::message($e->getMessage(), 'error');
            return false;
        }
        finally {
            // Ensure the database connection is always closed
            $mysqli?->close();
        }

    }

    private function getConn($dbName)
    {
        try {
            // Kapcsolódás az adatbázishoz
            $mysqli = mysqli_connect(self::DEFAULT_CONFIG["host"], self::DEFAULT_CONFIG["user"], self::DEFAULT_CONFIG["password"], $dbName);
    
            // Ellenőrizzük a csatlakozás sikerességét
            if (!$mysqli) {
                throw new Exception("Kapcsolódási hiba az adatbázishoz: " . mysqli_connect_error());
            }
    
            return $mysqli;
        } catch (Exception $e) {
            // Hibaüzenet megjelenítése a felhasználónak
            echo $e->getMessage();
        
            // Hibás csatlakozás esetén `null`-t ad vissza
            return null;
        }
    }

    private function setGlobalMaxAllowedPacket(){
        return $this->execSql("SET GLOBAL max_allowed_packet=1073741824;");
    }

    private function createDatabase(){
        return $this->execSql("CREATE DATABASE library CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }

    private function createTable(string $tableName, string $tableBody, string $dbName): bool
    {
        try {
            $sql = "
                CREATE TABLE `$dbName`.`$tableName`
                ($tableBody)
                ENGINE = InnoDB
                DEFAULT CHARACTER SET = utf8
                COLLATE = utf8_hungarian_ci;
            ";
            return (bool) $this->execSql($sql);

        } catch (Exception $e) {
            Display::message($e->getMessage(), 'error');
            return false;
        }
    }


    private function createTables($dbName = self::DEFAULT_CONFIG['database']){
        $this->createTablePublishers($dbName);
        $this->createTableCategories($dbName);
        $this->createTableWriters($dbName);
        $this->createTableBooks($dbName);
        $this->createTableReviews($dbName);
    }

    private function createTablePublishers($dbName){
        $tableBody = "
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
            name VARCHAR(50) NOT NULL";

        return $this->createTable('publishers', $tableBody, $dbName);
    }
    
    private function createTableCategories($dbName){
        $tableBody = "
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
            name VARCHAR(50) NOT NULL";

        return $this->createTable('categories', $tableBody, $dbName);
    }

    private function createTableWriters($dbName){
        $tableBody = "
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(50),
            bio VARCHAR(400) NOT NULL";

        return $this->createTable('writers', $tableBody, $dbName);
    }

    private function createTableBooks($dbName){
        $tableBody = "
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
            writerId INT, 
            publisherId INT,
            categoryId INT,
            title VARCHAR(50) NOT NULL, 
            coverImage mediumblob NOT NULL, 
            ISBN VARCHAR(50) NOT NULL, 
            price INT NOT NULL,
            content VARCHAR(800) NOT NULL,
            FOREIGN KEY (`writerId`) REFERENCES writers(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`publisherId`) REFERENCES publishers(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`categoryId`) REFERENCES categories(`id`) ON DELETE CASCADE";

        return $this->createTable('books', $tableBody, $dbName);
    }    

    private function createTableReviews($dbName){
        $tableBody = "
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            bookId INT NOT NULL,
            stars INT NOT NULL,
            FOREIGN KEY (`bookId`) REFERENCES books(`id`) ON DELETE CASCADE";

        return $this->createTable('reviews', $tableBody, $dbName);
    }

    private function getProperties($tableName){
        $propertiesFile = fopen("../files/$tableName/properties.txt", "r");
        $properties = explode("\n", fread($propertiesFile, filesize("../files/$tableName/properties.txt")));
        fclose($propertiesFile);
        return $properties;
    }

    private function getFiles($tableName){
        $files = array_diff(scandir("../files/$tableName/"), array('.', '..'));
        sort($files);
        return $files;
    }

    private function fillTables($dbName = self::DEFAULT_CONFIG['database']){
        $this->fillTablePublishers($dbName);
        $this->fillTableCategories($dbName);
        $this->fillTableWriters($dbName);
        $this->fillTableBooks($dbName);
    }

    private function fillTablePublishers($dbName){
        $properties = $this->getProperties("publishers");

        for ($i = 0; $i < count($properties); $i++){
            $currProperties = explode(";", $properties[$i]);
            $sql = "INSERT INTO `$dbName`.`publishers`(name) VALUES('" . $currProperties[0] . "')";
            $this->execSql($sql);
        }
    }

    private function fillTableCategories($dbName){
        $properties = $this->getProperties("categories");

        for ($i = 0; $i < count($properties); $i++){
            $currProperties = explode(";", $properties[$i]);
            $sql = "INSERT INTO `$dbName`.`categories`(name) VALUES('" . $currProperties[0] . "')";
            $this->execSql($sql);
        }
    }

    private function fillTableWriters($dbName){
        $properties = $this->getProperties("writers");

        for ($i = 0; $i < count($properties); $i++){
            $currProperties = explode(";", $properties[$i]);
            $sql = "INSERT INTO `$dbName`.`writers`(name, bio) VALUES('" . $currProperties[0] . "', '" . $currProperties[1] . "')";
            $this->execSql($sql);
        }
    }

    private function fillTableBooks($dbName){
        $properties = $this->getProperties("books");
        $files = $this->getFiles("books");

        for ($i = 0; $i < count($properties); $i++){
            $currProperties = explode(";", $properties[$i]);
            $sql = "INSERT INTO `$dbName`.`books`(writerId, publisherId, categoryId, title, coverImage, ISBN, price, content) VALUES(" . $currProperties[0] . ", " . $currProperties[1] . ", " . $currProperties[2] . ", '" . $currProperties[3] . "', LOAD_FILE('" . str_replace("\\","/",realpath("../files/books/" . $files[$i])) . "'), '" . $currProperties[4] . "', " . $currProperties[5] . ", '" . $currProperties[6] . "')";
            $this->execSql($sql);
        }
    }
}