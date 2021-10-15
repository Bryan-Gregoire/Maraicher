# PRJG5-MARAICHER-ESI

PRJG5-MARAICHER-ESI the project for the PRJG5 course. It is based on Laravel

## Installation

* Copy the _.env.example_ file to _.env_ to define your database credentials.

```bash
cp .env.example .env
```
* Run the composer install command to pull in the needed dependencies

```bash
composer install
```

* Generate an app key for the Laravel project :
```bash
php artisan key:generate
```

* Migrate the database

```bash
php artisan migrate:fresh
```

* _OPTIONAL_ :  Fill the database with dummy data to test
```bash
php artisan db:seed
```
// or when migrating :

```bash
php artisan migrate:fresh --seed

## Usage
* To run the server

```bash
php artisan serve
```

* To run tests
    * Define a _.env.testing_ file where you point to another database to avoid testing on the real database
    ```bash
    cp .env .env.testing
    ```
    * Run tests using the .env.testing as environnment
    ```bash
    php artisan test --env=testing
    ```
## npm installation (for bootstrap)
    npm i
    npm run dev

## link to access the project
 
## Contributors
    - 54892 Yassin Talhaoui 
    - 55130 Ihab Tazi
    - 52148 Chahed Akeche
    - 54027 Dylan Bricar 
    - 54627 Jeremie SESHIE 
    - 53735 Bryan Grégoire 
    - 54637 Billal ZIDI 

## License
[MIT](https://choosealicense.com/licenses/mit/)
