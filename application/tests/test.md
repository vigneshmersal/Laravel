# Test

Create overwrite when testing,
> .env.testing

Before test run,
> php artisan config/clear

To run test
> phpunit --env=testing
- php artisan test --group=feature

Create a test in the Feature directory...
> php artisan make:test UserTest

Create a test in the Unit directory...
> php artisan make:test UserTest --unit
