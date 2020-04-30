# Gate
Use by - `allows, denies, check, any, none, authorize, can, cannot`
At Blade - `@can, @cannot, @canany`

## Define
```php
Gate::define('edit-settings', function ($user) { return $user->isAdmin; });

Gate::define('update-post', function ($user, $post) { return $user->id === $post->user_id; });

Gate::define('update-post', 'App\Policies\PostPolicy@update');

Gate::before(function ($user, $ability) { });
Gate::after(function ($user, $ability, $result, $arguments) { });

Gate::guessPolicyNamesUsing(function ($modelClass) { }); // return policy class name...
```

## Check
```php
# current user actions
if (Gate::allows('edit-settings')) { }
if (Gate::allows('update-post', [$post])) { } // pass array
if (Gate::denies('update-post', $post)) { }
if (Gate::check('create-post', [$post])) { }

# check particular user actions
if (Gate::forUser($user)->allows('update-post', $post)) { }
if (Gate::forUser($user)->denies('update-post', $post)) { }

# Multiple actions
if (Gate::any(['update-post', 'delete-post'], $post)) { }
if (Gate::none(['update-post', 'delete-post'], $post)) { }

# Throw an AuthorizationException if the action is not authorized
Gate::authorize('update-post', $post);
```

# Policy
`viewAny, view, create, update, delete, restore, forceDelete`

1. Index   - viewAny
2. show    - view
3. create  - create
4. store   - create
5. edit    - update
6. update  - update
7. destroy - delete

## Check access
```php
if ($user->can('view', $post)) { }
if ($user->can('create', Post::class)) { }
if ($user->can('update', $post)) { }
if ($user->can('delete', $post)) { }

$this->user()->can('create.posts');

# Used in controller
$this->authorize('view', $post);
$this->authorize('view', Post::class);
$this->authorize('update', [$post, $category]);

# authorize resource controller
$this->authorizeResource(Post::class, 'post'); // 1st arg post model, 2nd arg route key {post}

# Blade
@can('update', $post)
@elsecan('create', App\Post::class)
@cannot('update', $post)
@elsecannot('create', App\Post::class)
@if (Auth::user()->can('update', $post))
@unless (Auth::user()->can('update', $post))
@canany(['update', 'view', 'delete'], $post)
@elsecanany(['create'], \App\Post::class)
```

## Policy Response
```php
use Illuminate\Auth\Access\Response;
return $user->id === $post->user_id ? Response::allow() : Response::deny('You do not own this post.');
```

# Role & Permission

