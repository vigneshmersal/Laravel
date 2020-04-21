# PHP artisan
Start development
> php artisan serve

Run php code
> php artisan tinker

Model
> php artisan make:model -mc

Middleware
> php artisan make:middleware CheckAge

Request
> php artisan make:request PackageRequest

Rule
> php artisan make:rule Uppercase

Controller
> php artisan make:controller PhotoController --resource --model=Photo

Database
> php artisan migrate

> php artisan migrate:fresh --seed

> php artisan db:seed

Database example
> - php artisan make:migration create_users_table
> - php artisan make:migration remove_user_id_from_posts_table

Component Blade
> php artisan make:component Alert
> php artisan make:component Alert --inline

Cache & Clear
- php artisan route:cache
- php artisan route:clear

- php artisan cache:clear

- php artisan view:cache
- php artisan view:clear

# Exception Error files
It will create a files at `resources/views/errors/` directory.
> php artisan vendor:publish --tag=laravel-errors
