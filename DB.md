# DB
Closure based
```php
DB::transaction(function() {
	// stripe
});

// Passing method variable
DB::transaction(function() use ($billable) {
	// stripe
});
```

Without closure
```php
try {
	DB::beginTransaction();
	// insert records
	DB::commit();
} catch (\Exception | \Throwable $e) {
	DB::rollback();
}
```
