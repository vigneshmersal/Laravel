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
