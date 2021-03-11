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
