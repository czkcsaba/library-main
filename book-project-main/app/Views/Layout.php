<?php

namespace App\Views;

class Layout{
    public static function header($title = "Library"){
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="hu">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$title</title>
            <script src="/js/script.js" type="text/javascript"></script>
            <link rel="stylesheet" href="/fontawesome/css/all.css" type="text/css">
            <link rel="stylesheet" href="/css/style.css" type="text/css">
        </head>
        <body>        
        HTML;
        self::navbar();
        self::handleMessages();
        echo '<div class="container">';
    }

    private static function navbar(){
        echo <<<HTML
        <nav class="navbar">
            <ul class="nav-list">
                <li class="nav-brand">📚 Library</li>
                <li><a href="/" title="Könyvek"><button class="nav-button">Könyvek</button></a></li>
                <li><a href="/writers" title="Szerzők"><button class="nav-button">Szerzők</button></a></li>
                <li><a href="/publishers" title="Kiadók"><button class="nav-button">Kiadók</button></a></li>
                <li><a href="/categories" title="Kategóriák"><button class="nav-button">Kategóriák</button></a></li>
            </ul>
        </nav>
        HTML;
    }

    private static function handleMessages(){
        $messages = [
            'succes_message' => 'succes',
            'warning_message' => 'warning',
            'error_message' => 'error',
        ];

        foreach ($messages as $key => $type){
            if (isset($_SESSION[$key])){
                Display::message($_SESSION[$key], $type);
                unset($_SESSION[$key]);
            }
        }
    }

    public static function footer() {
        echo <<<HTML
        </div>
            <footer> 
                <hr>
                <p>2025 &copy; Oszaczki Csaba</p>
            </footer>
        </body>
        </html>
        HTML;
    }
}