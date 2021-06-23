# Laravel 8 whats New
https://jetstream.laravel.com/1.x/features/teams.html#introduction
https://github.com/laravel/jetstream

https://github.com/aschmelyun/laravel-auth-videos

## Features
	- Two factor authentication - recovery code valid only once
	- Avatar upload - ui avatar
	- Browser session - session table - logout from all sessions
	- Api Token - instead of auth token - request->user()->tokenCan('create')
	- Jetstream - laravel/jetstream
	- Livewire
	- Inertia JS
	- fortify - laravel/fortify
## Changes
	- factory
	- route

### config/fortify.php
> register, reset, verify,
### config/jetstream.php
> avatar, profile, teams
php artisan vendor:publish --tag=jetstream-views
### Team
```php
auth()->user()->currentTeam->name
```
### Switch
> config/jetstream.php -> 'stack' => livewire | inertia
> Vue = php artisan jetstream:install inertia --teams | npm install & npm run dev
> composer require inertiajs/inertia-laravel
> npm run watch

composer require laravel/jetstream
php artisan jetstream:install livewire --teams
php artisan jetstream:install inertia --teams
