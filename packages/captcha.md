# [anhskohbo/no-captcha](https://github.com/anhskohbo/no-captcha)

Install
> composer require anhskohbo/no-captcha

```php
NoCaptcha::shouldReceive('verifyResponse')
   ->once()
   ->andReturn(true);
$response = $this->json('POST', '/register', [
   'g-recaptcha-response' => '1',
   'name' => 'Pardeep',
   'email' => 'pardeep@example.com',
   'password' => '123456',
   'password_confirmation' => '123456',
]);

```
