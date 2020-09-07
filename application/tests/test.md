# Test

Create overwrite when testing,
> .env.testing

Before test run,
> php artisan config/clear

Create a test in the Feature directory...
> php artisan make:test UserTest

Create a test in the Unit directory...
> php artisan make:test UserTest --unit

To run test
> vendor/bin/phpunit --env=testing

> php artisan test --group=feature

## phpunit.xml
```xml
<php>
    <!-- ... -->
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <!-- ... -->
</php>
```
