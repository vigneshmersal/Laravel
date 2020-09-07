# Local scope
> $messages = Message::published()->get();\

```php
public function scopePublished($query) {
	return $query->where('published', '>', 0);
}
```

## Dynamic local scopes
> $messages = Message::isHighlighted(true)->get();

```php
public function scopeIsHighlighted($query, $isHighlighted) {
    return $query->where('highlighted', $isHighlighted);
}
```

### Check local scope
> $user->isActive()

```php
public function scopeIsActive() { return $this->status == 1; }
```

___

# Model Global Scope
Create Scope
> php artisan make:scope MessageScope

app/Scopes folder
```php
<?php
namespace App\Scopes;
use Illuminate\Database\Eloquent\ {Builder, Model, Scope};
class MessageScope implements Scope {
	public function apply(Builder $builder, Model $model) {
		$builder->where('type', 1);
	}
}
```

Add its globally for this model only,
```php
protected static function boot() {
	parent::boot();
	static::addGlobalScope(new MessageScope());
}
```

## Removing a global scope
```php
Message::withoutGlobalScope(MessageScope::class)->get();
```

___

# Model Anonymous Global Scopes
```php
protected static function boot() {
	parent::boot();
	static::addGlobalScope('type', function (Builder $builder) {
		$builder->where('type', 1);
	});
}
```

## Removing a Anonymous Global Scopes
```php
Message::withoutGlobalScope('type')->get();
```


