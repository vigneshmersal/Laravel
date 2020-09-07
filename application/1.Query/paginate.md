## Paginate

```php
# take
collect([1,2,3,4])->take(2); // [1,2]
collect([1,2,3,4])->take(-2); // [3,4]

takeUntil(function ($item) { return $item>=3; }); // if true
takeWhile(function ($item) { return $item>=3; }); // if false

collect([1,2,3,4,5])->forPage($page=2, $items=2); // [3,4]

collect([1,2,3,4])->skip(2); // [3,4]

# get nth item
collect([1,2,3,4])->get()[$nth=1]; // [2]
collect([1,2,3,4])->values()->get($nth=1); // [2]
collect([1,2,3,4])->get()->slice($nth=1, $howmany=2); // [2,3]
```
