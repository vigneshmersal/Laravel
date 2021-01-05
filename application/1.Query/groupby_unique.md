## GroupBy
```php
# preserve key instead of [0] it will keep the key
->groupBy('column', $preserveKey=true)
# custom
->groupBy(function($item){ return $item['column']; });
```

## By multiple column
```php
groupBy(['column1', 'column2']) // column1 => [ column2 => [] ]

->groupBy(function ($item, $key) { return $item['column1'].$item['column2']; });
```

## By relation
```php
# By relations column
->groupBy('products.name')
```

## By custom column
```php
->groupBy(function($item, $key) {
    return Carbon::parse($item['date'])->format('m/d/Y'); //[03/12/2020]=>[]
    return Carbon::parse($val->start_time)->format('d');
    return substr($item['id'], -3); // match by x10
});
```

## By custom aggregate value
```php
->groupBy('country')->map(function ($row) {
    return $row->count(); //[India]=>2
    return $row->sum('amount'); // [india=>5000]
});
```

## raw
```php
# modify date column
->groupByRaw('YEAR(birth_date)')
->groupBy(\DB::raw("Month(created_at)"))

// havingRaw
->havingRaw('COUNT(*) > 1')
->havingRaw('YEAR(birth_date) > 2000')
Product::groupBy('name')->havingRaw('COUNT(*) > 1')->get();
```

## unique
```php
// By column [ ['a'=>6,'b'=>2] ]
collect([ ['a'=>6,'b'=>2],['a'=>5,'b'=>2] ])->unique($column='b');

# By multiple custom
unique(function($item){ return $item['col1'].$item['col2']; });
```
