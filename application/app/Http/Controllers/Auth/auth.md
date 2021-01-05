# Auth

Started,
> php artisan ui vue --auth

```php
# Get
$user = Auth::user();
$id = Auth::id();
$user = $request->user();

# Check
if (Auth::check()) { } // chk authenticated
if (Auth::viaRemember()) { } // chk authentication via $remember

# login Attempt
Auth::attempt($credentials);
Auth::guard('admin')->attempt($credentials);
Auth::attempt($credentials, $remember); // $remember - keep login until manually logout
Auth::once($credentials); // log for a single request (No sessions or cookies)

# login
Auth::login($user);
Auth::guard('admin')->login($user);
Auth::login($user, true); // Login and "remember" the given user...
Auth::loginUsingId(1);
Auth::loginUsingId(1, true); // Login and "remember" the given user...

# Logout
Auth::logout();
Auth::logoutOtherDevices($password); // use middleware - AuthenticateSession

# Custom guard
jwt - AuthServiceProvider
```

## Middleware
```php
auth
auth:api
password.confirm // confirm their password before they can continue
auth.basic // automatically prompted for credentials when accessing the route (default column-email)
auth.basic.once
```

## Logout from otherdevices
https://codezen.io/how-to-manage-logged-in-devices-in-laravel/

```php
// uncommand app/http/kernal.php
\Illuminate\Session\Middleware\AuthenticateSession::class,

// Auth/LoginController.php
protected function authenticated() {
    \Auth::logoutOtherDevices(request('password'));
}
```
