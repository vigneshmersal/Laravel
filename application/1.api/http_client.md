# Http Client
https://laravel.com/docs/8.x/http-client

install
> composer require guzzlehttp/guzzle

## Free testing apis
https://jsonplaceholder.typicode.com/

## Laravel Http Client Response Class
\vendor\laravel\framework\src\Illuminate\Http\Client\Response.php
```php
# data
$response->body(); // string data
$response->__toString(); // string data
$response->json(); // json data

# header
$response->headers(); 
$response->header('Date'); 

# status
$response->status(); // getStatusCode() 
$response->ok(); // status() == 200
$response->successful(); // status() >= 200 && status() < 300;
$response->redirect(); // status() >= 300 && status() < 400;
$response->clientError(); // status() >= 400 && status() < 500;
$response->serverError(); // status() >= 500
$response->failed(); // serverError || clientError
$response->throw(); // if invalid url, serverError || clientError -> throw RequestException

# url
$response->effectiveUri(); // url informations

```

## Usage
```php
use Illuminate\Support\Facades\Http;

$response = Http::get('https://jsonplaceholder.typicode.com/todos/1');

$response = Http::post('https://jsonplaceholder.typicode.com/posts', 
    ['title'=>'post']);

$response->offsetExists('title'); // true
$response['title']; // post
$response->offsetGet('title'); // post


Http::patch();
Http::put();
Http::delete();

# Form | attach | headers | withBasicAuth | withToken
$response = Http::asForm()
    ->withBody(
        base64_encode($photo), 'image/jpeg'
    ) // raw request
    ->attach(
        'attachment', file_get_contents('photo.jpg'), 'photo.jpg'
    ) // Multi-Part Requests
    ->attach(
        'attachment', fopen('photo.jpg', 'r'), 'photo.jpg'
    )
    ->withHeaders([
        'X-First' => 'foo',
        'X-Second' => 'bar'
    ])
    ->withBasicAuth('admin@admin.com', 'password')
    ->withDigestAuth('taylor@laravel.com', 'secret')
    ->withToken('token')
    ->timeout(3)
    ->retries(time: 2, wait-ms: 500)
    ->withOptions([
        'debug' => true,
    ])
    ->post(url, data);
```

# Invalid url
```
$response = Http::get('https://jsonplaceholder.typicode.com/sfgisgi');
$response->throw();
```

# Testing - fake response insteadof call the url
```php
# If different urls
Http::fake([
    'github.com/*' => Http::response(['foo' => 'bar'], 200, ['Headers']),
    // unmatched url
    '*' => Http::response('Hello World', 200, ['Headers']),
]);

# If same urls
Http::fake([
    'jsonplaceholder.*' => Http::sequence()
        ->push('Hello World', 200)
        ->push(['foo' => 'bar'], 200)
        ->whenEmpty(Http::response()), // default response, when empty
        ->pushStatus(404),
]);

Http::fakeSequence()
    ->push('Hello World', 200)
    ->whenEmpty(Http::response());

# callback - using database
Http::fake(function(){
    $query = Model::get();
    return Http::response();
})
```

# assert check
```php
Http::assertSent(function($request) {
    return true; // testing pass
    return $request->hasHeader('Date');
    return $request->url() == 'https://jsonplaceholder.typicode.com/todos/1'; 
    return $request['title'] == 'post1';
});

Http::assertNotSent(function (Request $request) {
    return $request->url() === 'http://test.com/posts';
});

Http::assertNothingSent();
```
