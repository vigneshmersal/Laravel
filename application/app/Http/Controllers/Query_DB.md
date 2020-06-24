# Laravel Query

## instantiate
```php
$user = new User;
$user = (new App\User)->newQuery();
```

## Get
```php
find($id);
find([$id1]);
findOrFail($id);

first();
firstWhere($column); // value is not null,0,[],''
firstWhere($column, $value);
firstWhere($column, $operator, $value);
first(function($v,$k){ return $v>1; });

last()
last(function($v,$k){ return $v>1; });

keys()
values()
pluck($val, $key)

get()
get([$column1])
get($column1, 'default')
get($column, function(){ return 'default'; })

all()
all([$column1])

only(['name']); // return specified column
except(['password']); // return except specified column
forget(['password']); // removes an item from the collection by its key

collect([1,2,3,4])->take(2); // [1,2]
collect([1,2,3,4])->take(-2); // [3,4]
takeUntil(function ($item) { return $item>=3; }); // if true
takeWhile(function ($item) { return $item>=3; }); // if false

# display
$collection->dd();
$collection->dump();
->tap(function($collection){ Log::debug('Values', $collection); }) // like return this
```

## set
```php
# combine key & val array
collect(['key1'])->combine(['value1']); // ['key1' => 'value1']

# merge array & replace val if key already exist
collect(['a'])->merge(['b']); // ['a','b']
collect(['a'=>1])->merge(['a'=>2,'b'=>3]); // ['a'=>2,'b'=>3]
collect(['a','b'])->zip([1,2]); // [['a',1], ['b',2]]

# merge array & replace val if key already exist
collect(['a'=>1])->union(['a'=>2,'b'=>3]); // ['a'=>1,'b'=>3]

# merge array
collect(['a'=>1])->mergeRecursive(['a'=>2,'b'=>3]); // ['a'=>[1,2],'b'=>3]

# prepend
prepend($val)
prepend($val,$key)

# set val whereever by position
collect([1,2,3,4])->splice($pos=2,$size=1,$newItems=[5,6]); // [1,2,5,6,4]

# append last
concat([$val])
push($val)
put($key, $val)

# copy to new collection
$collectionB = $collectionA->collect(); // copy - return new instance
```

## check
```php
# has key & val
contains($val)
contains($key, $val)
contains(function ($value, $key) { return $value > 5; })
search($val); // return key if val exist, else return false
search(function ($item, $key) { return $item>5; });

# has column
has([$column])

# hasAll
collect([1,2])->every(function($v,$k){ return $v > 0; }); // true

# empty|null
collect([])->isEmpty();
collect([])->isNotEmpty();
```

## delete
```php
# first
shift() // remove and return first item
collect([1,2,3,4])->skip($firstNoOfItems=2); // [3,4]
collect([1,2,3,4])->skipUntil($val=3); // [3,4]
collect([1,2,3,4])->skipWhile($val=3); // [3,4]
collect([1,2,3,4])->skipUntil(function ($item) { return $item>=3; }); // [3,4]
collect([1,2,3,4])->skipWhile(function ($item) { return $item<=3; }); // [4]

collect([1,2,3,4])->slice($pos=2); // [3,4]
collect([1,2,3,4])->slice($pos=2,$size=1); // [3]

collect([1,2,3,4])->splice($pos=2); // [3,4]
collect([1,2,3,4])->splice($pos=2,$size=1); // [3]

# last
pop() // remove last item
pull($column) // remove and return col val
```

## array
```php
$users->each->delete();

# foreach
$users->each->markAsVip();
collection([1,2])->each(function ($item, $key) { return false; }); // stop iteration by return false;
collect([['John',35],['Jane',33]])->eachSpread(function ($name, $age) { }); // nested foreach loop

# split array by condition
list($less,$more)=collect([1,2,3])->partition(function($i){ return $i<2; }); // $less=[1], $more=[2,3]

# swap key and val
collect(['k'=>'v'])->flip(); // ['v'=>'k']

# split single array to multiple array
$collection->chunk($number)->toArray() //  [[1, 2, 3, 4], [5, 6, 7]]
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

## condition
```php
where($column, $value); # default operator "="
where($column, $operator, $value)
whereNull($column)
whereNotNull($column)
whereBetween($column, [100,200])
whereNotBetween($column, [100,200])
whereIn($column, [1,2])
whereNotIn($column, [1,2])
collect([new User, new Post])->whereInstanceOf(User::class) // [App\User]

# group by
groupBy($column='id') // ['id' => 'account-x10'] maatch by account-x10
groupBy(function ($item, $key) { return substr($item['id'], -3); }); // match by x10
groupBy(['skill', function($item){ return $item['roles']; }], $preserveKeys=true);
collect([ ['a'=>6,'b'=>2],['a'=>5,'b'=>2] ])->unique($column='b') // [ ['a'=>6,'b'=>2] ]
unique(function($item){ return $item['col1'].$item['col2']; });

# change collection when pass
->when(true, function($c){ return $c->push(4); }, function ($c) { return $c->push(3); });
->when($status, $callback, $default);
->whenEmpty($status, $callback, $default);
->whenNotEmpty($status, $callback, $default);

->unless($status, $callback, $default);
->unlessEmpty($status, $callback, $default);
->unlessNotEmpty($status, $callback, $default);
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

## Save
```php
Model::fill($array)->save();
Model::create($array);
Model::insert($array); // manually add 'created_at,updated_at' => now()->toDateTimeString()
```

## calculation
```php
count() | count($column) // count no of items

reverse()

sort()
sortDesc()

sortBy($column)
sortByDesc($column)
sortBy(function ($item, $key) { return count($item['sub']); }); // sort by total sub item count

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

# extending macros // Call: $upper = $collection->toUpper();
Collection::macro('toUpper', function () {
    return $this->map(function ($value) { return Str::upper($value); });
});

# run no of times and create a new collection
Collection::times(5, function($n) { return $n*9; }); // [9,18,27,36,45]
```

## DB
```php
# get
DB::table('table_name')->get()->value('email');

# select
DB::select( DB::raw('SELECT * FROM `users`') );
```

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

## Database
```php
# Get table name from model instance
$instance->getTable();

# Get table columns
Schema::getcolumnListing($table);

# Check table column exist
if(Schema::hasColumn($table, $column)) { }
```

## class
```php
collect(['USD'])->mapInto(Currency::class); // [Currency('USD')] - create a new instance of the given class
```

## pagination
```php
collect([1,2,3,4,5])->forPage($page=2, $items=2); // [3,4]

collect([1,2,3,4])->skip(2); // [3,4]

collect([1,2,3,4])->take(2); // [1,2]
```

## optimize
```php
# Instead of create()
Model::insert($array); // manually add 'created_at,updated_at' => now()->toDateTimeString()

# loop faster by execute single query
foreach( App\Model::cursor() as $each ) { }

# cache query
Cache::remember('homepage-books', 60*60*24, function() {
	return $query;
});
Cache::forget('homepage-books'); // php artisan cache:clear

# solve n+1 query issue
Post::with('user')->get(); // instead of Post::all()

# livewire computed property (won't make a seperate database query every time)
public function getPostProperty() { // access by $this->post
    return Post::find($this->postId);
}
```
