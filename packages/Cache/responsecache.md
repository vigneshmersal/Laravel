# Spatie responsecache
https://github.com/spatie/laravel-responsecache

install
> composer require spatie/laravel-responsecache

publish
// config/responsecache.php
> php artisan vendor:publish --provider="Spatie\ResponseCache\ResponseCacheServiceProvider"

// app/Http/Kernel.php
```php
protected $routeMiddleware = [
   'doNotCacheResponse' => \Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
    'cacheResponse' => \Spatie\ResponseCache\Middlewares\CacheResponse::class,
];
```

// web.php
```php
Route::middleware('cacheResponse')->group(function () {
    Route::get('/{slug}', 'ArticleController');
});
```

// observer
```php
public function saved(Post $post) {
    ResponseCache::forget(url($post->slug));
}
```
