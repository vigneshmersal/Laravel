## Find
```php
find($id);
find([$id1]);
findOrFail($id);
```

## First
```php
first() , firstOrFail() ,
firstWhere($column); // value is not null,0,[],''
firstWhere($column, $value);
firstWhere($column, $operator, $value);
first(function($v,$k){ return $v>1; });
```

## Last
```php
last()
last(function($v,$k){ return $v>1; });
```

## column
```php
keys() | values()
pluck($val, $key)

value('column')

get() | get([$column1]) | get($column1, 'default')
get($column, function(){ return 'default'; })

all() | all([$column1])

only(['name']); // return specified column
except(['password']); // return except specified column
forget(['password']); // removes an item from the collection by its key
```
