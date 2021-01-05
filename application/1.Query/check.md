## overall check
```php
exists()
doesntExist()
->count() > 0

# empty|null
isset($c);
$c = collect([])->isEmpty();
collect([])->isNotEmpty();
```

## searchBy
```php
# hasAny
contains($val)
contains($key, $val)
contains(function ($value, $key) { return $value > 5; })

# hasAny (check and return key)
search($val); // if val exist return `key`, else return `false`
search(function ($item, $key) { return $item > 5; });

# hasAll
collect([1,2])->every(function($v,$k){ return $v > 0; }); // true
collect([1,2])->every(function($v,$k){ return $v > 3; }); // false
```

## relationship
```php
has('books')
has('books', '>', 5)
has('books.ratings') // two layer deep checking
whereHas('books', function($v,$k){ $v['col']>1 })
doesntHave('books')

# chk Relationship is eager loaded($product->with(['topics']))
$product->relationLoaded('topics') // true/false
```
