## from first
```php
# first
shift() // remove and return first item
collect([1,2,3,4])->skip($noOfItems=2); // [3,4]
collect([1,2,3,4])->skipUntil($val=3); // [3,4]
collect([1,2,3,4])->skipWhile($val=3); // [3,4]
collect([1,2,3,4])->skipUntil(function ($item) { return $item>=3; }); // [3,4]
collect([1,2,3,4])->skipWhile(function ($item) { return $item<=3; }); // [4]
```

## from middle
```php
collect([1,2,3,4])->slice($pos=2); // [3,4]
collect([1,2,3,4])->slice($pos=2,$size=1); // [3]

collect([1,2,3,4])->splice($pos=2); // [3,4]
collect([1,2,3,4])->splice($pos=2,$size=1); // [3]
```

# last
```
pop() // remove last item
pull($column) // remove and return col val
```

## force delete
```php
forceDelete()
```

## restore
```php
Model::withTrashed()->restore();
```
