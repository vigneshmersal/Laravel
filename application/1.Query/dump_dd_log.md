## Test

```php
# dd
$collection->dd();

# dump
$collection->dump();

# log at certain stages
->tap(function($collection){ Log::debug('Values', $collection); }) // like return this
```
