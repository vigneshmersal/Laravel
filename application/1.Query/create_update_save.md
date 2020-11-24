## Create Update

```php
Model::fill(['column'=>'val'])->save();
Model::create(['column' => 'val']);
$model->save(['timestamps' => false]);
$model->update(); // It will return affected rows

// chk if k/v exist - update, else create
Model::updateOrCreate(['k'=>'v'],['k1'=>'v1']); 
```

## Insert
```
// manually add 'created_at,updated_at' => now()->toDateTimeString()
Model::insert([]); 
Model::insertGetId($array);
```

## copy / clone / duplicate
```php
//copy attributes
$new = $model->replicate(); $new->save(); // copy of row and save as new
$new = clone $model;
```

## Increments and decrements
```php
$model->increment('column');
$model->decrement('column');

$model->increment('column', 5);
$model->decrement('column', 5);

Model::updateOrCreate([], [
    'column' => \DB::raw('column + 1'),
]);
```

## timestamp
```php
$user->timestamps=false; $user->save(); // update model, without timestamp
$user->touch(); // update updated_at timestamp
```

## restore
```php
Post::withTrashed()->where('author_id', 1)->restore();
```

## Duplicate save
```php
$newQs = $qs->replicate();
$newQs->mock_test_id = $mock_test_id;
$newQs->save();
```
