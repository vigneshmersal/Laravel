## comma seperated column
```php
# Found
->whereRaw('FIND_IN_SET(value, column)')
->whereRaw('FIND_IN_SET(value, column) > 0')

# Not Found
->whereRaw('NOT FIND_IN_SET(value, column)')
->whereRaw('FIND_IN_SET(value, column) = 0')
```

## where
```php
->where(function ($query) use ($activated) {
    $query->where('activated', '=', $activated);
})->get();

->where(function($query) {
    if ($query->isProduct()) $query->has('product');
    else $query->has('subscription');
})
```
