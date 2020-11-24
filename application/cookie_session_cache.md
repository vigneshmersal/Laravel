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

## cache
```php
# Retrive
$value = Cache::get('key');
$value = Cache::get('key', 'default');
$value = Cache::store('file')->get('foo');
$value = Cache::get('key', function () { return DB::table(...)->get(); });
$value = cache('key');

# Tag
$john = Cache::tags(['people', 'artists'])->get('John');
Cache::tags(['people', 'authors'])->flush();
Cache::tags('authors')->flush();
Cache::tags(['people', 'artists'])->put('John', $john, $seconds);
if (\Cache::tags($cache_tags)->has($cache_key)) {}


# Retrive & Remove
$value = Cache::pull('key');

# Remove
Cache::forget('key'); // remove item
Cache::put('key', 'value', 0);
Cache::put('key', 'value', -5);
Cache::flush(); // remove all items
php artisan cache:clear

# Store
Cache::put('key', 'value');
Cache::put('key', 'value', $seconds = now()->addMinutes(10));
Cache::increment('key');
Cache::increment('key', $amount);
Cache::decrement('key');
Cache::decrement('key', $amount);
Cache::add('key', 'value', $seconds); // Store If Not Present
Cache::forever('key', 'value'); // store forever , only remove by manually - `forget`
Cache::store('redis')->put('bar', 'baz', 600); // 10 Minutes
cache(['key' => 'value'], $seconds = now()->addMinutes(10));

# Check
if (Cache::has('key')) {}

# Retrieve & Store // if not exist, default will be execute
$value = Cache::remember('users', $seconds, function () {
    return DB::table('users')->get();
});
cache()->remember('users', $seconds, function () {
    return DB::table('users')->get();
});
$value = Cache::rememberForever('users', function () {
    return DB::table('users')->get();
});
```
