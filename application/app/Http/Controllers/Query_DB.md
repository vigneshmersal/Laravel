# Laravel Query
## Get
```php
find(1);
findOrFail(1);
find([1 ,2]);

all();
first();
get();
get([$column1, $column2]);

$user = (new User)->newQuery();
```

## condition
```php
// default operator "="
where($column, $operator, $value);

where($column, $value);
```

## Eloquent Relationships
```php
# Best of Eager loading - to solve (N+1) issue
with('comments');
with('comments' => function() {  });
with('posts.comments');
```

## convert
```php
->toSql();
->toJson();
->toArray();
->newCollection();
```

## Laravel
```php
$this->getKeys($models = "App\User", $this->localKey = "id"); // It will return ids 1,2,...
```

## DB
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
