# Test
https://scotch.io/tutorials/introduction-to-laravel-dusk

## Dusk
> composer require --dev laravel/dusk
> php artisan dusk:install
> php artisan dusk:make SectorTest
> php artisan dusk
> php artisan dusk:fails // rerun last failed tests

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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\DatabaseMigrations; // rollback all migrations
use Illuminate\Foundation\Testing\DatabaseTransactions; // rollback new entries
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;

private $user;
public function setup() {
	parent::setup();
	$this->user = factory(User::class)->make();
}

/**
 * @test
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
```php
$user = factory(User::class)->create([ 'email' => 'taylor@laravel.com' ]);
$admin = \App\User::find(1);

// multiple browser test
$this->browse(function ($first, $second) { });

$this->browse(function ($browser) use ($user) {
	$browser->visit('/')
		->value('#name', 'Joe')  // fill form
		->type('@name', 'Example company')
		->type('email', $user->email)
		->type('password', 'password')
		->press('Login')
		->click('Click Me'); // <a href="#">Click Me</a>
		->click('button[type="submit"]') //Click the submit button on the page
		->click('#login')
		->click('.login-page .container div > button')
		->assertPathIs('/home') //Make sure you are in the home page
		->loginAs($admin)
		->waitForText('Message')
		->waitFor('@company-form')
		->pause(4000);
});

$browser->resize(1920, 1080);
$browser->maximize();
$browser->fitContent();

// we expect the result is manual exception
$this->expectException(ManualException::class);

// login as
$response = $this->actingAs($anotherUser, 'api')
	->get('/api/v1/companies/'.$company->id);

$this->post($url, $data = [], $headers);
```

## assert
```php
$this->assertTrue(); | $this->assertFalse();

$response->assertStatus(200); // 403

$this->assertSee('<h1>hi</h1>'); // content
$this->assertDontSee('<h1>hi</h1>');
$this->assertEquals(); // match value
$this->assertContains('<h1>hi</h1>', $content); // content
$this->assertNull();
$this->assertCount();
$this->assertEmpty();

$this->seePageIs('/feedback'); // url
$this->assertRedirect('/docs/8');

$response->assertExactJson([
	'message' => "Successfully created user!",
]);
```
