minimize database query + minimize memory limit = fast page (<500ms)

```php
$model->with('relation1');

//load relations on EXISTING MODEL
$model->load('relation1','relation2');
```

```php
# it will call all the posts and make collection filter
# 50 users * 100 posts = 5000 call
foreach($users as $user) { 
    $user->posts->sortByDesc('created_at')->first()->created_at->difForHumans()
}

# recommand
foreach($users as $user) { 
    $user->posts()->latest()->first()->created_at->difForHumans()
}
```
