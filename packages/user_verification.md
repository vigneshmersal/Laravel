# package
[jrean/laravel-user-verification](https://github.com/jrean/laravel-user-verification)

## Install
> composer require jrean/laravel-user-verification

Publish config,
> php artisan vendor:publish --provider="Jrean\UserVerification\UserVerificationServiceProvider" --tag="config"

publish migrations,
> php artisan vendor:publish --provider="Jrean\UserVerification\UserVerificationServiceProvider" --tag="migrations"

migrate tables,
> php artisan migrate --path="/vendor/jrean/laravel-user-verification/src/resources/migrations"

register middleware,
```php
protected $routeMiddleware = ['isVerified' => \Jrean\UserVerification\Middleware\IsVerified::class];
```

## Use
```php
Route::group(['middleware' => ['isVerified']], function () {});
```

## specification
- Generate and store a verification token for a registered user
- Send or queue an e-mail with the verification token link
- Handle the token verification
- Set the user as verified
- Relaunch the process anytime
