## A projektről

Ez a projekt a BigFish számára készült próbafeladat gyanánt.
A feladat leírását e-mail-ben kaptam.

## Szerver szükségletek:

- PHP >= 7.1.3
- PDO PHP Extension
- JSON PHP Extension
- MySQL >= 5.0

## Telepítés

GIT Repo klónozása:
```
git clone https://CmdNetWizard@bitbucket.org/CmdNetWizard/bigfish.git
```
Composer futtatása:
```
composer install
```
`.env` fájl létrehozása `.env.examlpe` alapján, valamint a megfelelő adatbázis kapcsolat beállítasa ugyanezen fájlban:
```
DB_DATABASE=bigfish
DB_USERNAME=bigfish
DB_PASSWORD=******
```
Szükség esetén az `.env` fájlban az `APP_URL`-t át kell írni a megfelelőre.

Az adatbázis kapcsolat létrejötte után már csak migrálni kell az adatbázisunkat, valamint feltölteni adatokkal. Ezt a következő parancs segítségével lehet:
```
php artisan migrate --seed
```

És már használható is az alkalmazás. :)

### Felhasznált third-party komponensek:

- Laravel 5.6
- laravel-debugbar
- laravel-ide-helper
- Bootstrap 4
- jQuery
- Toastr

A termék képekért köszönet a Bookline-nak, pontosabban az oldaluknak