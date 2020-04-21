# URL

## Retrive
```php
$route = Route::current();
$name = Route::currentRouteName();
$action = Route::currentRouteAction();

# get full url
$url = route('profile', ['id' => 1]);
$url = url("/posts/{$post->id}");
$url = action('UserController@profile', ['id' => 1]);
$url = url()->current(); // Without Query String
$url = URL::current(); // Without Query String
$url = $request->url(); // Without Query String
$url = $request->fullUrl(); // With Query String
$url = url()->full(); // With Query String

// get url path -> foo/bar
$path = $request->path();

# Retrieve Request Method (post,get)
$method = $request->method();

# Get the full URL for the previous request...
$previous = url()->previous();
```

## check
```php
# check url path
if ($request->is('admin/*')) { }

# check url route name
if (Request::route()->named('doctor.*')) { }

# check route method
if ($request->isMethod('post')) { }
```
