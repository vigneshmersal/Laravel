# Response

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

## [file](https://github.com/symfony/symfony/blob/3.0/src/Symfony/Component/HttpFoundation/File/UploadedFile.php)
```php
# download
return response()->download($pathToFile);
return response()->download($pathToFile, $name, $headers);
return response()->download($pathToFile)->deleteFileAfterSend();

# display
return response()->file($pathToFile);
return response()->file($pathToFile, $headers);
```
