# New Project

## New project setup
```php
composer create-project --prefer-dist laravel/laravel blog "5.5.*"
// or
composer create-project laravel/laravel=5.5 blog --prefer-dist

set vhost & restart xampp

v 7: composer require laravel/ui
v 7: php artisan ui:auth `(without style)`
v 7: php artisan ui bootstrap `(style)`
v 5,6: php artisan make:auth

composer install

add public/.htaccess

set .env

composer update

add .gitignore, .gitattributes

npm install

create database -> with collection as -> utf8_unicode_ci
php artisan migrate

config\database.php -> mysql -> strict -> false

sudo apt-get install php5.6-xml // IF PHP VERSION=5.6
```
