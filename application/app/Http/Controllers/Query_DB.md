## instantiate
```php
$user = (new App\User)->newQuery();
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
User::chunk(100, function ($users) {
    foreach ($users as $user) { }
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

# WHERE (gender = 'Male' and age >= 18) or (gender = 'Female' and age >= 65)
$q->where(function ($query) {
    $query->where('gender', 'Male')->where('age', '>=', 18);
})->orWhere(function($query) {
    $query->where('gender', 'Female')->where('age', '>=', 65);
})

$q->orWhere(['b' => 2, 'c' => 3]);

# change collection when pass
->when($request->has('search'), function ($q) use ($request) {
    return $q->where('name', 'like', "%".$request->search."%");
})
Model::query()->when(true, function ($q) { return $q->where('likes', '>', 0); });
->when(true, function($c){ return $c->push(4); }, function ($c) { return $c->push(3); });
->when($status, $callback, $default);
->whenEmpty($status, $callback, $default);
->whenNotEmpty($status, $callback, $default);

->unless($status, $callback, $default);
->unlessEmpty($status, $callback, $default);
->unlessNotEmpty($status, $callback, $default);
```

## Group by & having
```php
# preserve key
->groupBy('column', $preserveKey=true) // preserve key instead of [0] it will keep the key
# By relation column
->groupBy('products.name')
# modify date column
->groupByRaw('YEAR(birth_date)')
->groupBy(function($item, $key) {
    return Carbon::parse($item['created_at'])->format('m/d/Y'); }); // [03/12/2020] => []
# modify column
->groupBy(function($item, $key) { return strlen($item['name']); }); // alter group key
->groupBy(function ($item, $key) { return substr($item['id'], -3); }); // match by x10
# By calc
->groupBy('country')->map(function ($row) { return $row->count(); }); // [India] => 2
->groupBy('country')->map(function ($row) { return $row->sum('amount'); }); // [india=>5000]
# Group By multiple column
->groupBy(function ($item, $key) { return $item['country'].$item['city']; });
groupBy(['column1', 'column2']) // column1 => [ column2 => [] ]
->groupBy(['skill', function($item){ return $item['roles']; }]);

// havingRaw
Product::groupBy('category_id')->havingRaw('COUNT(*) > 1')->get();
->havingRaw('YEAR(birth_date) > 2000')
->orderByRaw('YEAR(birth_date)')

# unique
collect([ ['a'=>6,'b'=>2],['a'=>5,'b'=>2] ])->unique($column='b') // [ ['a'=>6,'b'=>2] ]
unique(function($item){ return $item['col1'].$item['col2']; });
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

$user->timestamps=false; $user->save(); // update model, without timestamp
$user->touch(); // update updated_at timestamp

# Order by relationship
$users = Topic::with('latestPost')->get()->sortByDesc('latestPost.created_at');
# Order by Mutator
$clients = Client::get()->sortBy('full_name'); // first_name.' '.last_name
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

# instead of passing hole response, get used data's only in array format
User::all(); // bulk
User::get()->toArray(); // hole column
User::get()->pluck('name')->toArray(); // less column

# cache query
$cacheKey = md5(vsprintf('%s.%s', [$user->id,$days]))
Cache::remember('index.posts', $seconds = 30, function() { // time - 60*60*24
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

