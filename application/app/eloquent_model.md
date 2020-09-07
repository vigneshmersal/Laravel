# Eloquent

[hasOne](#hasone)
[belongsTo](#belongsTo)
[hasMany](#hasMany)
[belongsToMany](#belongsTo)
[hasOneThrough](#hasOneThrough)
[hasManyThrough](#hasManyThrough)

## hasOne
(one to one)

```php
Class User{
	public function phone() {
		return $this->hasOne('App\Phone', 'foreign_key'='user_id', 'local_key'='id');
	}
}

$phone = User::find(1)->phone;
```

## belongsTo {#belongsTo}
one to one Inverse, one to many Inverse

```php
protected $touches = ['post']; // update parent 'updated_at' timestamp

Class Phone {
	public function user() {
	    return $this->belongsTo('App\User', 'foreign_key'='user_id', 'other_key'='id');
	}
}
class Comment extends Model {
    public function post() {
        return $this->belongsTo('App\Post');
    }
}

// save author_id
$phone->user()->associate($instance);
$phone->save();

$comment->post->title;
```

## hasMany (one to many)

```php
class User extends Model {
    public function posts() {
        return $this->hasMany('App\Posts', 'foreign_key', 'local_key');
    }
    public function productsByName() {
		return $this->hasMany(Product::class)->orderBy('name');
	}
}
class Post extends Model {
    public function comments() {
        return $this->hasMany('App\Comment');
    }
}

$users = User::has('posts')->get(); // user has posts
$users = User::doesntHave('posts')->get(); // user does not have posts
$users = User::has('posts', '>=', 7)->get(); // user has atleast 7 posts

$users = User::has('posts')->has('comments')->get(); // user has posts and comments
$users = User::has('posts')->orHas('comments')->get(); // user has posts or comments

$users = User::has('posts.comments')->get(); // deep chk, user has posts and post has comments
$users = User::has('posts.comments', '>', 5)->get(); // deep chk, user has posts and post has atleast 5 comments

$users = User::whereHas('posts', function($query) { // user has featured posts
	return $query->where('is_featured', 1);
})->get();

$users = User::whereHas('posts', function($query) { // user has featured posts and awarded comments
	return $query->where('is_featured', 1);
})->whereHas('comments', function() {
	return $query->where('is_awarded', 1);
})->get();

$users = User::whereHas('posts', function($query) { // user has featured posts or awarded comments
	return $query->where('is_featured', 1);
})->orWhereHas('comments', function() {
	return $query->where('is_awarded', 1);
})->get();

$users = User::whereNotNull('email_verified_at') // user has verified or awarded comments
->orWhereHas('comments', function() {
	return $query->where('is_awarded', 1);
})->get();

$user->posts()->where('active', 1)->get(); // relationship condition
```

## belongsToMany (many to many) {#belongsToMany}

```php
class User extends Model { // table - role_user
    public function roles() {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')
        	->using('App\RoleUser') // custom pivot table
        	->as('subscription') // rename 'pivot'
        	->withPivot('column1', 'column2') // pass additional data
        	->wherePivot('approved', 1)
            ->wherePivotIn('priority', [1, 2])
            ->wherePivotNotIn('priority', [1,2])
        	->withTimestamps();
    }
}

foreach ($user->roles as $role) { }
$roles = $user->roles()->orderBy('name')->get();

# Intermediate Table Columns Retrive
$role->pivot->created_at;

$users = User::with('podcasts')->get();
foreach ($users->flatMap->podcasts as $podcast) {  // flatMap instead of two foreach
    echo $podcast->subscription->created_at; // subscription instead of pivot
}

# attach given ids
$user->roles()->attach([$roleIds]);
$user->roles()->attach([$roleIds], ['expires' => $expires]); // with additional data
$user->roles()->attach([ 1 => ['expires' => $expires], 2 => ['expires' => $expires] ]); // with individual additional record

# detach given ids
$user->roles()->detach([$roleIds]); // Detach a single role from the user...
$user->roles()->detach(); // Detach all roles from the user...

// Any IDs that are not in the given array will be removed from the intermediate table
// only the IDs in the given array will exist in the intermediate table
$user->roles()->sync([1,2,3]);
$page->tags()->wherePivot('feature_id', 1)->sync($tagIds); // with condition
$user->roles()->sync([1 => ['expires' => true], 2, 3]); // pass additional data
$user->roles()->syncWithoutDetaching([1, 2, 3]); // If you do not want to detach existing IDs
$user->roles()->syncWithoutDetaching([ 1 => ['expires' => true] ]); // with additional data
$user->roles()->sync([1,2,3], false); // If you do not want to detach existing IDs

# sync ids array with additional data
foreach($data as $id){
	$syncData[$id] = ['question_score' => 1];
}
$paper->questions()->sync($syncData);

# If the given ID is currently attached, it will be detached. Likewise detached
$user->roles()->toggle([1, 2, 3]);
```

## hasOneThrough {#hasOneThrough}

```php
# mechanic has one car, car has one owner
# get mechanic has owner
class Mechanic extends Model {
    public function carOwner() {
        return $this->hasOneThrough('App\Owner','App\Car',
            'mechanic_id', // Foreign key on cars table...
            'car_id', // Foreign key on owners table...
            'id', // Local key on mechanics table...
            'id' // Local key on cars table...
        );
    }
}
```

## hasManyThrough {#hasManyThrough}

```php
# country has many users, users has many posts
# get country has many posts
class Country {
    public function posts() {
        return $this->hasManyThrough('App\Post', 'App\User',
            'country_id', // Foreign key on users table...
            'user_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }
}
class User { // posts.comments
    public function comments() {
        return $this->hasManyThrough(Comment::class, Post::class)
            ->where('posts.status', 1);
    }
}
```
