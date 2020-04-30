# Laravel Query
## Get
```php
find($id); | find([$id1]); | findOrFail($id);
first();

all(); | all([$column1]);
get(); | get([$column1]);

$user = (new model)->newQuery();
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

## Save
```php
$user->fill([
    'secret' => encrypt($request->secret), // encrypt
])->save();
```

## DB

```php
DB::table('table_name')->get()->value('email');

DB::select(
    DB::raw('SELECT * FROM `users`')
);
```

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

## Schema

```php
# Get table name from model instance
$instance->getTable();

# Get table columns
Schema::getcolumnListing($table);

# Check table column exist
if(Schema::hasColumn($table, $column)) { }
```
