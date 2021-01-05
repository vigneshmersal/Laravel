## instantiate
```php
$user = (new App\User)->newQuery();
```

## add new item at first
```php
# prepend
prepend($val)
prepend($val,$key)
```

## add new item to last
```php
# append last
concat([$val])
push($val)
put($key, $val)
```

## merge key & value pair
```php
# combine key & val array
collect(['key1'])->combine(['value1']); // ['key1' => 'value1']
```

## merge values to existing key
```php
# merge array & replace val if key already exist
collect(['a'])->merge(['b']); // ['a','b']
collect(['a'=>1])->merge(['a'=>2,'b'=>3]); // ['a'=>2,'b'=>3]
```

## merge create new format
```php
collect(['a','b'])->zip([1,2]); // [['a',1], ['b',2]]

# merge array & skip val if key already exist
collect(['a'=>1])->union(['a'=>2,'b'=>3]); // ['a'=>1,'b'=>3]

# merge array
collect(['a'=>1])->mergeRecursive(['a'=>2,'b'=>3]); // ['a'=>[1,2],'b'=>3]

# set val whereever by position
collect([1,2,3,4])->splice($pos=2,$size=1,$newItems=[5,6]); // [1,2,5,6,4]

# copy to new collection
$collectionB = $collectionA->collect(); // copy - return new instance
```

## array
```php
$users->each->delete();
$users->each->markAsVip();

# foreach
collection([1,2])->each(function ($item, $key) { return false; }); // stop iteration by return false;
collect([['John',35],['Jane',33]])->eachSpread(function ($name, $age) { }); // nested foreach loop

# split array by condition
list($less,$more)=collect([1,2,3])->partition(function($i){ return $i<2; }); // $less=[1], $more=[2,3]

# swap key and val
collect(['k'=>'v'])->flip(); // ['v'=>'k']

# split single array to multiple array
$collection->chunk($number)->toArray() //  [[1, 2, 3, 4], [5, 6, 7]]
User::chunk(100, function ($users) {
    foreach ($users as $user) {
        $q->push($user);
    }
});
$collection->split($number)->toArray() //  [[1, 2, 3, 4], [5, 6, 7]]

# join multiple array to single array
$collapsed = $collection->collapse(); // chunk to flat [1,2,3,4,5,6,7]

# counts the occurrences of each values
$collection->countBy(); // [ val1 => 2, val2 => 3 ]

# countBy - matching format on each values
$collection->countBy(function ($each) { return substr(strrchr($each, "@"), 1); }); // ['gmail.com' => 2, 'yahoo.com' => 1]

# return the differences
collect([1, 2, 3])->diff([2]); // [1, 3]
collect(['one' => 10])->diffKeys(['two'=>2]); // ['one'=>10]
collect(['color' => 'orange'])->diffAssoc(['color' => 'yellow']); // ['color'=>'orange']

# return the matches
collect([1, 2, 3])->intersect([2]); // [2]
collect(['one' => 10])->intersectByKeys(['one'=>2]); // ['one'=>10]

# filter collection
collect([ 1,null,false,'',0,[] ])->filter(); // [1]
collect([1,2])->filter(function ($v, $k) { return $v > 1; }); // [2]
collect([1,2])->reject(function($v, $k){ return $v>1; }); // [1]

# modify each values
collect([['k'=>'v']])->flatMap(function ($eachValue) { return strtoupper($eachValue); }); // ['k'=>V]
collect([1,2])->transform(function($item, $key){ return $item*2; }); // [2,4] - modifies the collection
collect([1,2])->map(function($item, $key){ return $item*2; }); // [2,4] - returns a new instance, does not modify the original collection
// After Eloquent query you can modify rows
$users = User::where('role_id', 1)->get()->map(function (User $user) {
    $user->some_column = some_function($user);
    return $user;
});
collect([[0,1],[2,3]])->mapSpread(function ($even, $odd) { return $even+$odd; }); // [1,5] nested foreach loop
collect(['c1'=>1,'c2'=>2],['c1'=>1,'c2'=>3])->mapToGroups(function ($item, $key) { return [$item['c1']=>$item['c2']]; }); // [ 1=>[2,3] ] - convert values to key=>val pair
collect(['c1'=>1,'c2'=>2],['c1'=>1,'c2'=>3])->mapWithKeys(function ($item, $key) { return [$item['c1']=>$item['c2']]; }); // [ 1=>3 ] - convert values to key=>val pair (but val will be replaced if the key already exis)

# reduce
collect([1,2,3])->pipe(function($collection) { return $collection->sum(); }); // 6
collect([1,2,3])->reduce(function($carry, $item){ return $carry + $item; }); // 6
collect([1,2,3])->reduce(function($carry, $item){ return $carry + $item; }, $initial=4); // 10

# replace
collect(['a','b'])->replace([1=>'c']); // [a,c]
collect(['a',['b','c']])->replaceRecursive([1=>[1=>'d']]); // ['a',['b','d']]

# get duplicate values
collect(['a','b','a','a'])->duplicates(); // [2=>a,3=>a] (with position)
collect([ ['b'=>'z'], ['b'=>'z'] ])->duplicates('b'); // [0=>'z'] - chk duplicate values in a given column

collect(['a','b','a'])->unique(); // ['a','b']
unique($column)

# convert multi-dimensional to single-dimensional
collect(['a'=>'x','b'=>['y']])->flatten(); // ['x','y']
collect(['a'=>'x','b'=>['y']])->flatten($depth=1); // ['x','y']

# resize/padding array by given val
collect(['a'])->pad(3,'@'); // ['a','@','@']
collect(['a'])->pad(-3,'@'); // ['@','@','a']

random()
random($total)
shuffle()
```

## Eloquent Relationships
```php
# Best of Eager loading - to solve (N+1) issue
Post::with('comments');
Post::with(['comments:id,body'])->get(); // eager loading with select specific columns
has('products', '>' , 10)
$posts = Post::with(['comments' => function($query) {
    return $query->select(['id', 'body']);
}])->get();
Post::with('posts.comments');
Post::with('comments' => function() {  });
Post::with(['comments as active_comments' => function ($query) {
    $query->where('approved', 1); // condition for comments table
    $query->orderBy('created_at', 'desc');
}])->get();
Post::with(['comments.user' => function ($query) {
    $query->where('active', 1); // condition for user table
}])->get();

Post::withCount([
    'comments', 		// comments_count=50
    'comments as active_comments_count' => function ($query) {
        $query->where('approved', 1);
    }
])->get();
# nested relation
User::withCount('posts')->withCount([
    'posts' => function(\Illuminate\Database\Eloquent\Builder $query){ $query->withCount('videos'); }
])->all();
# double nested relation
"mock_questions_count" => (int) $this->mockTests->reduce(function ($count, $mockTests) {
    return $count + $mockTests->mockQuestions->count();
}),
```

## convert
```php
->toSql();
->toJson(); // '{"name":"Desk", "price":200}'
->toArray(); // [['name' => 'Desk', 'price' => 200]]
->newCollection();

# convert array to string
collect([1,2])->implode(','); // '1,2'
collect([1,2])->join(','); // '1,2
# convert column values to string
collect([['a'=>'1'],['a'=>'2']])->implode($column='a',$join=','); // 1,2

# add key from column value
collect([['1'=>'a'],['1'=>'b']])->keyBy('1'); // [a=>['1'=>'a'],b=>['1'=>'b']]
keyBy(function($item){ return strtoupper($item['1']); }); // [A=>['1'=>'a'],B=>['1'=>'b']]
```

## calculation
```php
count() | count($column) // count no of items

sortKeys()

sum() | sum($column) | sum(function($item) { return count($item); });
avg() | avg($column)
min() | min($column)
max() | max($column)

collect([1, 1, 2, 4])->median(); // 1.5
median($column)

collect([1, 1, 2, 4])->mode(); // 1

collect(['a','b','c','d','e','f'])->nth($nth=2); // ['a','c','e']
collect(['a','b','c','d','e','f'])->nth($nth=2,$start=1); // ['b','d','f']

# crossjoin
collect([1, 2])->crossJoin(['a', 'b']); // [ [1, 'a'], [1, 'b'], [2, 'a'], [2, 'b'] ]
```

## Collection
```php
# create
$collection = collect([1, 2, 3]);

# get (city=>no_of_times)
array_count_values($products->pluck('city')->toArray()); // [1=>5,2=>7]

# pass collection as foreach and return new array
return collect(['a'=>1])->map(function ($v, $k) { return ['id' => $k]; }); // ['a'=>['id'=>'a']]
return collect(['a'=>1])->map(function ($v, $k) { return ['id' => $k]; })->values(); // [['id'=>'a']]

# extending macros // Call: $upper = $collection->toUpper();
Collection::macro('toUpper', function () {
    return $this->map(function ($value) { return Str::upper($value); });
});

# run no of times and create a new collection
Collection::times(5, function($n) { return $n*9; }); // [9,18,27,36,45]
```

## class
```php
collect(['USD'])->mapInto(Currency::class); // [Currency('USD')] - create a new instance of the given class
```

