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
