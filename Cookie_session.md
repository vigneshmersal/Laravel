# cookie

```php
use Illuminate\Support\Facades\Cookie;

# get data
$value = $request->cookie('name');
$value = Cookie::get('name');

$cookie = Cookie::make('name', 'value', $minutes);
Cookie::queue($cookie);
Cookie::queue('name', 'value', $minutes);

# attach to response
return response('Hello World')
	->cookie( $cookie )
	->cookie('name', 'value', $minutes)
	->cookie( 'name', 'value', $minutes, $path, $domain, $secure, $httpOnly );
```

## session
file - sessions are stored in `storage/framework/sessions`
```php
# Retrive
$value = session('key', 'default');
$data = $request->session()->all();
$value = $request->session()->get('key', 'default');
$value = $request->session()->get('key', function () { return 'default'; });

# Store
session(['key' => 'value']);
$request->session()->put('key', 'value');
$request->session()->push('user.teams', 'developers'); // array store
$request->session()->flash('status', 'Task was successful!'); // store only next request
$request->session()->reflash(); // keep your flash data for several requests
$request->session()->keep(['username', 'email']); // keep specific flash data for several requests

# Delete
$request->session()->forget(['key1', 'key2']);
$request->session()->flush();
$value = $request->session()->pull('key', 'default'); // array delete

# Check
if ($request->session()->has('users')) { }
if ($request->session()->exists('users')) { }
```
