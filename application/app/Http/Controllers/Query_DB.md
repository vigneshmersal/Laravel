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
firstOrFail();
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

# hasAll
collect([1,2])->every(function($v,$k){ return $v > 0; }); // true

# empty|null
$c = collect([])->isEmpty();
isset($c);
collect([])->isNotEmpty();

Author::hasMany(Book::class); // get authors by with books
Author::has('books', '>', 5)->get(); // chk authors by with books > 5
Author::has('books.ratings')->get(); // get authors by with book ratings

# chk Relationship is eager loaded($product->with(['topics']))
$product->relationLoaded('topics') // true/false
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

## restore
```php
Post::withTrashed()->where('author_id', 1)->restore();
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

## Increments and decrements
```php
Post::find($post_id)->increment('view_count');
User::find($user_id)->increment('points', 50);
```

## Date
```php
$products = Product::whereDate('created_at', '2018-01-31')->get();
$products = Product::whereMonth('created_at', '12')->get();
$products = Product::whereDay('created_at', '31')->get();
$products = Product::whereYear('created_at', date('Y'))->get();
$products = Product::whereTime('created_at', '=', '14:13:58')->get();
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

// havingRaw
Product::groupBy('category_id')->havingRaw('COUNT(*) > 1')->get();

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
Post::with('comments');
Post::with(['comments:id,body'])->get(); // eager loading with select specific columns
$posts = Post::with(['comments' => function($query) {
    return $query->select(['id', 'body']);
}])->get();
Post::with('posts.comments');
Post::with('comments' => function() {  });
Post::with(['comments as active_comments' => function (Builder $query) {
    $query->where('approved', 1); // condition for comments table
    $query->orderBy('created_at', 'desc');
}])->get();
Post::with(['comments.user' => function (Builder $query) {
    $query->where('active', 1); // condition for user table
}])->get();

Post::withCount([
    'comments', 		// comments_count=50
    'comments as active_comments_count' => function (Builder $query) {
        $query->where('approved', 1);
    }
])->get();
# nested relation
User::withCount('posts')->withCount([
    'posts' => function(\Illuminate\Database\Eloquent\Builder $query){ $query->withCount('videos'); }
])->all();
```

## softdelete
```php
Post::withTrashed()->where('author_id', 1)->restore();
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
Model::insertGetId($array);
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

## sorting
```php
reverse()

sort()
sortDesc()

sortBy($column)
sortByDesc($column)
sortBy(function ($item, $key) { return count($item['sub']); }); // sort by total sub item count

Instead of:
User::orderBy('created_at', 'desc')->get();
You can do it quicker:
User::latest()->get(); // latest() will order by created_at.
User::oldest()->get();
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

// change table column name
$users = DB::table('users')->select('name', 'email as user_email')->get();

Product::groupBy('category_id')->havingRaw('COUNT(*) > 1')->get();
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

collect([1,2,3,4])->get()[$nth=1]; // [2]
collect([1,2,3,4])->values()->get($nth=1); // [2]
collect([1,2,3,4])->get()->slice($nth=1, $howmany=2); // [2,3]
```

## optimize
```php
return 'Memory Usage: '.round(xdebug_peak_memory_usage()/1048576, $precision=2) . 'MB';

# Instead of create()
Model::insert($array); // manually add 'created_at,updated_at' => now()->toDateTimeString()
DB::insert('insert into users (email, votes) values (?, ?)', ['john@example.com', '0']);

# where condition use best filter on more data
where('created_at', '>', now()->subDays(29)) // use date filter first
where('name', 'like', '%vig%') // use like filter second

# loop faster by execute single query
foreach( App\Model::cursor() as $each ) { }

# To load bulk data from server like 100120 data's it will take more memory 100MB
# But if u use cursor() it will split the query and optimize the memory into 16MB
# Usecase - No, one will show 100000 records on a single page. But there are much other use cases where you may need to fetch 100000 records. For example, you may need for report generating like analytics, or to update each record for some reason, or you may need to send a notification to 100000 users or you may need to clean up some records based on some conditions. There are many many use cases where you may need to fetch 100000 records.
Question::all();
Question::cursor(10000, function($questions){});

# cache query
Cache::remember('index.posts', 30, function() { // time - 60*60*24
    return Post::all(['id', 'name']);
	return Post::with(['user:id,name', 'comments'])->get()->map(function($post) {
        return [
            'title' => $post->title,
            'comments' => $post->comments->pluck('body'),
        ];
    })->toArray(); // toArray() - store data's only
}); // use blade files as array format
Cache::forget('index.posts'); // php artisan cache:clear

# solve n+1 query issue
Post::with('user')->get(); // instead of Post::all()
Hotel::with('city')->withCount(['bookings'])->get(); // bookings_count
$post->load('user');

# livewire computed property (won't make a seperate database query every time)
public function getPostProperty() { // access by $this->post
    return Post::find($this->postId);
}

faster application into 100x
- php artisan route:cache (boostrap/cache/route.php)
- php artisan optimize

faster config/ dir: (get .env value and minimized array stored in - boostrap/config/cache.php)
- php artisan config:cache (to remove -> clear:cache)

Composer optimize autoload (one-to-one-association of the class)
- composer dumpautoload -o

Fastest cache & session driver:
- memcached

remove unused service, add in
- config/app.php

package
- laravel page speed

Object cache
- singleton
```
