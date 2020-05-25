# Middleware

## Authentication
```php
# Authentication
middleware('auth');
middleware('auth:api');

# Attaching the password.confirm middleware to a route will redirect users to a screen where they need to confirm their password before they can continue:
middleware('password.confirm');

# Check email is verified
middleware('verified');
```


## Role & Permission
```php
middleware('can:create',App\Post);
middleware('can:update,post');
middleware('can:viewAny,App\post');
```
