# slug
```php
Str::slug()
```

[cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable)
## Install
> composer require cviebrock/eloquent-sluggable

```php
class Post extends Eloquent
{
   use Sluggable;
   protected $fillable = ['title'];
   public function sluggable() {
       return [
           'slug' => [
               'source' => ['title']
           ]
       ];
   }
}
$post = new Post([
   'title' => 'My Awesome Blog Post',
]);
// $post->slug is "my-awesome-blog-post
```

___
[spatie/laravel-sluggable](https://packagist.org/packages/spatie/laravel-sluggable)
