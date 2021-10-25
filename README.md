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
    * Make sure the file dusk.sqlite exists inside databases folder !
    * Run an artisan serve using **the dusk.local environment**, this is to ensure that the real database is not altered
      by the tests
    ```bash
    php artisan serve --env=dusk.local
    ```
    * Run tests using dusk command
    ```bash
    php artisan dusk
    ```

## link to access the project

    https://maraicher-esi.herokuapp.com/

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
