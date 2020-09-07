## Transaction
```php
# Closure based
DB::transaction(function() use ($billable) {
    // stripe
});

# Without closure
try {
    DB::beginTransaction();
    // insert records
    DB::commit();
} catch (\Exception | \Throwable $e) {
    DB::rollback();
}
```
