```php
class AppServiceProvider extends ServiceProvider {
    public function boot()
    {
        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
        });
        \DB::listen(function ($sql, $bindings, $time) {
            \Log::info($sql, $bindings, $time);
        });
    }
}
```


```php
ddd($someVar)

->toSql()
```

# Tinker
```php
>>> DB::listen(function ($query) { dump($query->sql); dump($query->bindings); dump($query->time); });
=> null
>>> App\User::get()
"select * from `users` where `users`.`deleted_at` is null"
[]
19.58
```

```php
DB::flushQueryLog();
DB::enableQueryLog();
App\User::get()
$arr = DB::getQueryLog();
dd($arr);
```
