# package
[socialite](https://github.com/laravel/socialite)
Facebook, Twitter, Google, LinkedIn, GitHub , GitLab and BitBucket.

[Documentation](https://laravel.com/docs/7.x/socialite)

## use
```php
$user = Socialite::driver('github')->user();
// OAuth Two Providers
$token = $user->token;
$refreshToken = $user->refreshToken; // not always provided
$expiresIn = $user->expiresIn;
// All Providers
$user->getId();
$user->getName();
$user->getEmail();
$user->getAvatar();
```
