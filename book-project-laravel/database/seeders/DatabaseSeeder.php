<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Writer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            'Animus Könyvek',
            'Műszaki Könyvkiadó',
            'Európa Könykiadó',
            'Cartaphilus Könyvkiadó',
        ];

        foreach ($publishers as $name) {
            Publisher::firstOrCreate(['name' => $name]);
        }

        $categories = [
            'életrajz',
            'gyermekmese',
            'kalandregény',
            'fantasy',
            'ifjúsági regény',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        $writers = [
            ['name' => 'Szoboszlai Zsolt', 'bio' => 'Magyar sportszakember és édesapa, aki fiáról, Szoboszlai Dominikról írt részletes és személyes hangvételű életrajzi könyvet. Műve betekintést ad egy világsztár futballista gyerekkorába, fejlődésébe és a családi háttérbe.'],
            ['name' => 'Bartos Erika', 'bio' => 'Magyar írónő és illusztrátor, a népszerű Bogyó és Babóca mesesorozat alkotója. Művei kedves, egyszerű és szeretetteljes történeteikkel a legkisebb gyerekek kedvencei.'],
            ['name' => 'Jonathan Swift', 'bio' => '18.századi ír író, esszéista és szatirikus, legismertebb műve a Gulliver utazásai. Írásai éles társadalomkritikát fogalmaznak meg humorral és iróniával.'],
            ['name' => 'J.K.Rowling', 'bio' => 'Brit írónő, aki világhírűvé vált a Harry Potter sorozattal, amely minden idők egyik legsikeresebb könyvszériája. Munkái gazdag világépítésükről és erős karaktereikről ismertek.'],
            ['name' => 'Gwenda Bond', 'bio' => 'Amerikai írónő, aki több ifjúsági és fantasy regényt írt, köztük a Stranger Things előzménykönyveit. Történetei gyakran misztikus, karakterközpontú világokat mutatnak be.'],
        ];

        foreach ($writers as $writer) {
            Writer::firstOrCreate(['name' => $writer['name']], $writer);
        }

        $books = [
            [1, 1, 1, 'A Szoboszlai-sztori', 'A_Szoboszlai_sztori.jpg', '9789636147990', 6299, 'A könyv Szoboszlai Dominik gyerekkorától kezdve végigköveti a világszintű futballfelemelkedéséig vezető utat. Részletesen bemutatja az edzésmódszereket, a családi támogatást és azokat a döntő pillanatokat, amelyek meghatározták karrierjét. Az édesapa őszinte visszaemlékezései egy tehetség kitartásáról, küzdelmeiről és a sikerért hozott áldozatokról mesélnek.'],
            [2, 2, 2, 'Bogyó és Babóca – A szivárvány', 'Bogyo_es_Baboca.webp', '9786156911247', 3685, 'A történet Bogyó és Babóca barátságáról és közös kalandjairól szól, ezúttal a színes szivárvány felfedezésével a középpontban. A mese szeretettel és egyszerű tanulságokkal vezet be a kisgyerekek világába, miközben játékos, kedves szereplők mutatják meg a barátság, együttműködés és kíváncsiság fontosságát. Ideális olvasmány a legkisebbek számára.'],
            [3, 3, 3, 'Gulliver utazásai', 'Gulliver_utazasai.jpg', '9630754428', 960, 'Gulliver négy különleges utazásának története egyszerre szórakoztató kalandregény és éles társadalmi szatíra. A lilliputi apró emberek, az óriások földje, a repülő sziget különc tudósai és a bölcs, lótestű houyhnhnmok mind olyan világok, melyek tükröt tartanak az emberiségnek. Swift műve a kalandokon keresztül az emberi természet hibáit, a politikai visszásságokat és a társadalmak furcsaságait leplezi le.'],
            [4, 1, 4, 'Harry Potter és az Azkabani fogoly', 'Harry_Potter_es_az_Azkabani_Fogoly.jpg', '9789636140878', 4227, 'Harry harmadik tanévében kiderül, hogy egy veszélyes bűnöző, Sirius Black megszökött az Azkabani börtönből, és látszólag őt keresi. A Roxfortba új fenyegetések érkeznek a dementorokkal együtt, miközben Harry múltjának titkai lassan felszínre kerülnek. A történet sötétebb hangulatú, izgalmas fordulókkal és váratlan igazságokkal teli fejezet a varázsvilágban.'],
            [4, 1, 4, 'Harry Potter és a Tűz Serlege', 'Harry_Potter__es_a_Tuz_Serlege.jpg', '9789636140571', 5990, 'Harry rejtélyes körülmények között bekerül a veszélyes Trimágus Tusába, ahol életveszélyes próbákon kell helytállnia. Ahogy a verseny halad előre, egyre nyilvánvalóbbá válik, hogy valaki a háttérből irányítja az eseményeket. A könyv mérföldkő a sorozatban: sötétebb tónusú, drámai befejezéssel és Voldemort visszatérésével, ami mindent megváltoztat a varázsvilágban.'],
            [5, 4, 5, 'Stranger Things – Gyanakvó elmék', 'Stranger_Thing_Gyanakvo_Elmek.jpg', '9789632666723', 5699, 'A regény a sorozat előzményeit meséli el Terry Ives szemszögéből, aki fiatal nőként bekerül a hawkinsi labor kísérletei közé. A titkos program veszélyes pszichikai teszteket végez rajta és társain, amelyek a későbbi események alapját képezik. A könyv bemutatja, hogyan kezdődött Eleven története és hogyan indultak a labor sötét, törvényszegő kísérletei, melyek később Hawkins egész városát veszélybe sodorták.'],
        ];

        foreach ($books as $book) {
            [$writerId, $publisherId, $categoryId, $title, $image, $isbn, $price, $content] = $book;
            $path = public_path('images/books/' . $image);

            Book::firstOrCreate(
                ['title' => $title],
                [
                    'writerId' => $writerId,
                    'publisherId' => $publisherId,
                    'categoryId' => $categoryId,
                    'coverImage' => File::exists($path) ? File::get($path) : '',
                    'ISBN' => $isbn,
                    'price' => $price,
                    'content' => $content,
                ]
            );
        }
    }
}
