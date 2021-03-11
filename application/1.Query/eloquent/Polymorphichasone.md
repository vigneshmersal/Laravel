### polymorphichasone
```php
use Illuminate\Database\Eloquent\Builder;

// Retrieve comments associated to posts or videos with a title like foo%...
// $comments = App\Comment::whereDoesntHaveMorph(
$comments = App\Comment::whereHasMorph(
    'commentable',
    ['App\Post', 'App\Video'], // or 'App\Post' or '*'
    function (Builder $query) { $query->where('title', 'like', 'foo%'); }
)->get();

$comments = App\Comment::whereHasMorph(
    'commentable', *,
    function (Builder $query, $type) {
        $query->where('title', 'like', 'foo%');
        if ($type === 'App\Post') { $query->orWhere('content', 'like', 'foo%'); }
    }
)->get();

// eager load
$activities = ActivityFeed::query()
    ->with(['parentable' => function (MorphTo $morphTo) {
        $morphTo->morphWithCount([
            Photo::class => ['tags'],
            Post::class => ['comments'],
        ]);
    }])->get();

$activities = ActivityFeed::with('parentable')
    ->get()
    ->loadMorphCount('parentable', [
        Photo::class => ['tags'],
        Post::class => ['comments'],
    ]);

use Illuminate\Database\Eloquent\Relations\MorphTo;
$activities = ActivityFeed::query()
    ->with(['parentable' => function (MorphTo $morphTo) {
        $morphTo->morphWith([
            Event::class => ['calendar'],
            Photo::class => ['tags'],
            Post::class => ['author'],
        ]);
    }])->get();

$activities = ActivityFeed::with('parentable')
    ->get()
    ->loadMorph('parentable', [
        Event::class => ['calendar'],
        Photo::class => ['tags'],
        Post::class => ['author'],
    ]);
```
