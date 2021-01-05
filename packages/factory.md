# Factory

## Install
[laravel-test-factory-helper](https://github.com/mpociot/laravel-test-factory-helper)
> composer require --dev mpociot/laravel-test-factory-helper

## Use
This package will generate factories from your existing models,
> php artisan generate:model-factory

Overwriting existing model factories,
> php artisan generate:model-factory --force

For specific models,
> php artisan generate:model-factory User Team

```php
[ // laravel 8
	'user_id' => User::factory(),
]
User::factory()->admin()->count(3)->make();
# HasMany
User::factory()->has(Post::factory()->count(5))->create(); // create 1 user with 5 posts
User::factory()->hasPosts(5)->create(); // same
# BelongsTo
Post::factory()->for(User::factory())->count(3)->create(); // create 3 posts with 1 user
Post::factory()->forUser()->count(3)->create(); // same
Post::factory()->count(3)->create(); // each will create a new user

public function admin() {
	return $this->state([
		'admin' => true,
	]);
}
```

___
## Testing dummy data package
[TestDummy](https://github.com/laracasts/TestDummy)
