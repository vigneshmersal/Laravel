# Test
https://www.cloudways.com/blog/laravel-unit-testing/
# Create Test class

Create overwrite when testing,
> .env.testing

Before test run,
> php artisan config/clear

Create a test in the Feature directory...
> php artisan make:test UserTest

Create a test in the Unit directory...
> php artisan make:test UserTest --unit

class UserTest extends TestCase {}
class UserTest extends PHPUnit_Framework_TestCase {}

> cd /project  && /project/vendor/phpunit/phpunit/phpunit /project/tests/Feature/FileTest.php --filter '/::it_works_test_function_name$/'

---

## Run Test

To run test
> vendor/bin/phpunit --env=testing

test only this group
> php artisan test --group=feature

test except that group
> php artisan test --exclude=feature

here group is
```php
/**
 * @group feature
 */
public function testFunction() {}
```

---

## phpunit.xml
```xml
<php>
    <!-- ... -->
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <!-- ... -->
</php>
```

---

## visit page
$this->visit('/');
$this->click('Click Me'); // <a href="#">Click Me</a>

## assert
$this->assertTrue();
$this->assertFalse();

$this->assertSee('<h1>hi</h1>'); // content
$this->assertEquals(); // match value
$this->assertContains('<h1>hi</h1>', $content); // content
$this->assertNull();
$this->assertCount();
$this->assertEmpty();

$this->seePageIs('/feedback'); // url
$this->assertRedirect('/docs/8');
