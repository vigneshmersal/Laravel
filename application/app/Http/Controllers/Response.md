# Response

# Json pretty print
> return response($status, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

```php
# passing data to view
return view('admin.profile', ['name' => 'vignesh'])
	->withName('vignesh')
	->with('name', 'vignesh');

# check if first view exist - useful while creating packages
return view()->first(['custom.admin', 'admin'], compact('name'));

# pass response status to view
return response()->view('hello', $data, 200);

# return back
return back()->withErrors($validator)->withInput($request->except('password'));

// array
return response()->json([ 'name' => 'vignesh' ]);
```

## redirect
```php
return redirect('/login');
return redirect()->route('profile');
return redirect()->action('HomeController@index', ['id'=>1]);
return redirect()->away('https://www.google.com'); // Redirecting To External Domains
return redirect('register')->withErrors($validator, 'login'); // return named validation errors
```

## Attach header & cookie
```php
return response('Hello World', 200)
	->header('Content-Type', 'text/plain')
	->withHeaders([ 'Content-Type' => 'text/plain' ])
    ->cookie('name', 'value', $minutes)
	->cookie( 'name', 'value', $minutes, $path, $domain, $secure, $httpOnly );
```

## API
```php
use Symfony\Component\HttpFoundation\Response;
Response::HTTP_CREATED
Response::HTTP_ACCEPTED
Response::HTTP_FORBIDDEN
return response(null, Response::HTTP_NO_CONTENT);
```
