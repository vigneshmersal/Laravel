# Redis

https://github.com/phpredis/phpredis

https://pecl.php.net/package/redis/5.3.2RC2/windows

https://aregsar.com/blog/2020/configure-laravel-to-use-php-redis/

PhpRedis is a PHP extension for communicating with the Redis storage.

Predis is the alternative for PhpRedis on pure PHP and does not require any additional C extension by default, but it can be optionally paired with phpiredis.

PhpRedis is faster about x6 times. Using igbinary serializer reduces stored data size about 3x times. If Redis installed on separate machines, reducing network traffic is a very significant speedup.

Predis is perfect for the job and by adding phpiredis you can get a nice speed bump almost for free.

Using Predis:
0.132 seconds to fetch 30000 keys using "KEYS *".

Using phpredis:
0.045 seconds to fetch 30000 keys using "KEYS *".

Using Predis paired with phpiredis:
0.047 seconds to fetch 30000 keys using "KEYS *".

## Laravel Config
.env
```php
SESSION_DRIVER=redis
```

config/database.php
```php
'client' => env('REDIS_CLIENT', 'predis'), // phpredis
```

> composer require predis/predis

## Install in system
https://github.com/microsoftarchive/redis/releases
(or)
homestead out of the box

install redis.zip
set environment variable in system - redis path
default port - 6379
(or)
install redis.msi file

## Redis Cli
```php
# start server
redis-server
# open redis cli
redis-cli

# check 
ping 
app()->make('redis')

# commands
set key val
get key
flushall

# get all keys are stored
keys *
keys article.*

# get all article views values
zRange articleViews 0 -1
```

---

## Help
help [command:incr]
> help incr

---

## Commands
https://redis.io/commands

### Form
```php
# Custom functions
function remember($key, $minutes, Closure $callback) {
    if (! is_null($value = Redis::get($key))) return json_decode($value);
    Redis::setex($key, $minutes, $value = $callback());
    return $value;
}

function rememberForever($key, Closure $callback) {
    if (! is_null($value = Redis::get($key))) return json_decode($value);
    Redis::set($key,$value = $callback());
    return $value;
}

# Laravel provided by default
interface Articles {
    public function all();
}
class CacheableArticle implements Articles {
    protected $articles;
    public function __construct($articles) {
        $this->articles = $articles;
    }
    public function all() 
    {
        return Cache::remember('articles.all', 60 * 60, function() {
            return $this->articles->all();
        });
    }
}
class EloquentArticles implements Articles {
    public function all() {
        return App\Article::all();
    }
}
App::bind('Articles', function(){
    return new CacheableArticle(new EloquentArticles); // on/off cacheable
});
Route::get('/', function(Articles $articles) {
    return $articles->all();
});


if ($value = Redis::get('posts.all')) {
    return json_decode($value);
}
Redis::set('posts.all', $posts);
Redis::setex('posts.all', 60, $posts);
```

### Cache pagination and query api
```php
# issue
// yourdomain.com/products?page=2&sort_by=price
// yourdomain.com/products?sort_by=price&page=2
$fullUrl = request()->fullUrl();
return Cache::remember($fullUrl, $minutes, function () use ($data) {
    return $data;
});

# solution
$url = request()->url();
$queryParams = request()->query();
ksort($queryParams); //Sorting query params by key (acts by reference)
$queryString = http_build_query($queryParams); //Transforming the query array to query string
$fullUrl = "{$url}?{$queryString}";
$fullUrl = sha1($fullUrl); // hash url
return Cache::remember($fullUrl, $minutes, function () use ($data) {
    return $data;
});
```

### Get
```php
$redis = Redis::connection();
$redis->get('key');

$posts = json_decode(Redis::get('posts.all'));

Redis::dbSize(); // Return the number of keys in selected database.
```

### Set
```php
Redis::set('posts.all', $posts);
Redis::setex('posts.all', 60 * 60 * 24, $posts);
```

### Delete
```php
Redis::del('key');
Redis::executeRaw(["KEYS", "{$key}*"]); // delete matching string

if (Redis::zScore("articleViews", $id)) {}
```

### Check
```php
Redis::exists('articles.all')
```

### Increment/Decrement
```php
$visits = Redis::incr("article:$id:visits");
$visits = Redis::incrBy("article:$id:visits", 5);
```

### L - list
```php
LPUSH
LPOP
LINDEX
LINSERT 
LRANGE
```

### z - sort
```php
Redis::zadd('trending_article', 50, 'test'); // just add item
Redis::zadd('recent_article', time(), 'test'); // just add item
Redis::zrange('trending_article', 0, -1, WITHSCORES); // list items in asc
Redis::zrevrange('trending_article', 0, -1, WITHSCORES); // list items in desc
Redis::zcard('trending_article'); // count no of items
Redis::zincrBy('trending_article', 1, $article); // create key if not exist and increment

# z-sort, remove range of items
Redis::zremrangebyrank('trending_article'); 

App\Article::hydrate(array_map('json_decode', $trendings));
// fetching same order
collect($ids)->map(function($id) { return App\Article::find($id); });
```

### h - hash, m - multiple
```php
$user1Stats = [ 'a' => 10, 'b' => 20, 'c' => 30 ];

Redis::hmset('user.1.stats', $user1Stats)
Redis::hget('user.1.stats', 'a')    // 10
Redis::hgetall('user.1.stats')      // a 10 b 20 c 30
Redis::hgetall('user.1.stats')['a'] // 10
Redis::hincrby('user.1.stats', 'favorites', 1)
```

---

## Use redis Cache Drive in Laravel:
.env
```php
CACHE_DRIVER=redis
```

```php
return Cache::remember('posts.all', 60 * 60 * 24, function () { 
    return Post::all(); 
}); 

get laravel:key
```

