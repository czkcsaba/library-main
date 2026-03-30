## Indítás

- A dokumentum gyökér (DocumentRoot) legyen a `public/` mappa.
- MySQL-ben kell egy `library` nevű adatbázis a megfelelő táblákkal (`books`, `writers`, `publishers`, `categories`, `reviews`).

> DB beállítás alapértelmezetten: host=`localhost`, user=`root`, password=`null`, db=`library`.
> Ezt a `app/Database/Database.php` fájlban tudod átírni.

## Fő végpontok

## CRUD + egyéb végpontok

> Auth: jelenleg **nincs** (N)

| URL | HTTP method | Auth | JSON Response |
|---|---:|:---:|---|
| `/` | GET | N | API health (ok + info) |
| `/api/books` | GET | N | összes könyv (lista) |
| `/api/books/{id}` | GET | N | 1 könyv adatai |
| `/api/books` | POST | N | új könyv létrehozva |
| `/api/books/{id}` | PATCH | N | könyv módosítva |
| `/api/books/{id}` | DELETE | N | könyv törölve |
| `/api/books/{id}/reviews` | GET | N | adott könyv értékelései |
| `/api/books/{id}/rating` | POST | N | értékelés mentve (`stars: 1..5`) |
| `/api/writers` | GET | N | összes szerző |
| `/api/writers/{id}` | GET | N | 1 szerző |
| `/api/writers` | POST | N | új szerző létrehozva |
| `/api/writers/{id}` | PATCH | N | szerző módosítva |
| `/api/writers/{id}` | DELETE | N | szerző törölve |
| `/api/publishers` | GET | N | összes kiadó |
| `/api/publishers/{id}` | GET | N | 1 kiadó |
| `/api/publishers` | POST | N | új kiadó létrehozva |
| `/api/publishers/{id}` | PATCH | N | kiadó módosítva |
| `/api/publishers/{id}` | DELETE | N | kiadó törölve |
| `/api/categories` | GET | N | összes kategória |
| `/api/categories/{id}` | GET | N | 1 kategória |
| `/api/categories` | POST | N | új kategória létrehozva |
| `/api/categories/{id}` | PATCH | N | kategória módosítva |
| `/api/categories/{id}` | DELETE | N | kategória törölve |

## Képfeltöltés (books)

A `coverImage` mezőt 2 módon tudod megadni:
1) `multipart/form-data` feltöltéssel `coverImage` néven
2) vagy `coverImage` mezőben `LOAD_FILE('...')` formában.

A lekérdezésekben a `coverImage` base64-ként jön vissza JSON-ban.
