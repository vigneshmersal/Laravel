## comma seperated column
```php
# Found
->whereRaw('FIND_IN_SET(value, column)')
->whereRaw('FIND_IN_SET(value, column) > 0')

# Not Found
->whereRaw('NOT FIND_IN_SET(value, column)')
->whereRaw('FIND_IN_SET(value, column) = 0')
```

## Where
```php
where($column, $value); # default operator "="
where($column, $operator, $value)
```

## orWhere
```php
# Scope orWhere
$users = App\User::popular()->orWhere->active()->get();
```


## Custom condition
```php
->where(function ($query) use ($activated) {
    $query->where('activated', '=', $activated);
})->get();

->where(function($query) {
    if ($query->isProduct()) $query->has('product');
    else $query->has('subscription');
})
```

## null
```php
whereNull($column)
whereNotNull($column)
```

## between
```php
whereBetween($column, [100,200])
whereNotBetween($column, [100,200])
```

## In
```php
whereIn($column, [1,2])
whereNotIn($column, [1,2])
```

## object
```php
collect([new User, new Post])->whereInstanceOf(User::class) // [App\User]
```

## orWhere
```php
# WHERE (gender = 'Male' and age >= 18) or (gender = 'Female' and age >= 65)
$q->where(function ($query) {
    $query->where('gender', 'Male')->where('age', '>=', 18);
})->orWhere(function($query) {
    $query->where('gender', 'Female')->where('age', '>=', 65);
})

// chain
$q->orWhere(['b' => 2, 'c' => 3]);
```

## when
```php
->when($status, $callback, $default);
->whenEmpty($status, $callback, $default);
->whenNotEmpty($status, $callback, $default);

# change collection when pass
->when($request->has('search'), function ($q) use ($request) {
    return $q->where('name', 'like', "%".$request->search."%");
})

->when(true, function ($q) { return $q->where('key', 'val'); });

# if/else
->when(condition,
    function($c){ return $c->push(4); },
    function ($c) { return $c->push(3); });
```

## unless
```php
->unless($status, $callback, $default);
->unlessEmpty($status, $callback, $default);
->unlessNotEmpty($status, $callback, $default);
```

## doesntHave
```php
$posts = App\Post::doesntHave('comments')->get();

$posts = App\Post::whereDoesntHave('comments', function (Builder $query) {
    $query->where('content', 'foo');
})->get();

Product::doesntHave('categories')->ordoesntHave('countries')->get();
Product::whereDoesntHave('categories', function($q){ })
	->orWhereDoesntHave('countries', function($q){ })->get();
```
