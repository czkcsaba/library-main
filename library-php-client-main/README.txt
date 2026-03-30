Library API PHP kliens
======================

Ez a csomag egy több fájlból álló PHP kliens a meglévő REST API-hoz.

Tudja:
- könyvek listázása, keresése, rendezése
- könyvek létrehozása, módosítása, törlése
- írók létrehozása, módosítása, törlése
- kiadók létrehozása, módosítása, törlése
- kategóriák létrehozása, módosítása, törlése
- csillagos értékelés mentése a review résznél
- review lista csillagokkal

Fontos:
- a writers résznél a név és a bio is szerkeszthető
- a reviews résznél a kliens a books/{id}/rating és books/{id}/reviews végpontokat használja
- ha az API nem támogat valamelyik mezőt, akkor azt az API oldalon is ellenőrizni kell

Ajánlott API URL:
http://localhost:8000/api

Indítás:
1. Másold a projektet egy mappába, pl. htdocs/library-client
2. Nyisd meg böngészőben:
   http://localhost/library-client/public/

vagy beépített szerverrel:
php -S localhost:8080 -t public

Utána böngészőben:
http://localhost:8080
