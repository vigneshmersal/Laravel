
# change column name
```php
->select('email', 'email as user_email')
```

# From subquery
```php
DB::table(function($query) {
    $query->selectRaw('sum(amount) as total')->from('donations')->groupBy('user_id');
}, 'donations')->avg('total');
```

# Custom new field - Subquery Selects
```php
# 1.model cast
$protected $casts = [ 'last_posted_at' => 'date' ];
# 2. withcast
$query->withCasts([
    'last_posted_at' => 'date',
    'last_posted_at' => UserCode::class, // custom cast
]);

$users = User::select([
        'users.*',
        'last_posted_at' => Post::selectRaw('Max(created_at)')
        ->whereColumn('user_id', 'users.id')
    ])->get();

return Destination::addSelect(['last_flight' => Flight::select('name')
    ->whereColumn('destination_id', 'destinations.id')
    ->orderBy('arrived_at', 'desc')
    ->limit(1)
])->get();
```

## Subquery Ordering
```php
return Destination::orderByDesc(
    Flight::select('arrived_at')
        ->whereColumn('destination_id', 'destinations.id')
        ->orderBy('arrived_at', 'desc')
        ->limit(1)
)->get();
```

## subquery date & full relation
```php
public function scopeWithLastInteractionDate($query)
{
    $subQuery = \DB::table('interactions')
        ->select('created_at')
        ->whereRaw('customer_id = customers.id')
        ->latest()
        ->limit(1);

    return $query->select('customers.*')->selectSub($subQuery, 'last_interaction_date');
}

$customers = Customer::with('company')
    ->withLastInteractionDate()
    ->orderByName()
    ->paginate();

<td>{{ $customer->last_interaction_date->diffForHumans() }}</td>

protected $casts = [
    'last_interaction_date' => 'datetime',
];

# improvement
public function scopeWithLastInteractionDate($query)
{
    $query->addSubSelect('last_interaction_date', Interaction::select('created_at')
        ->whereRaw('customer_id = customers.id')
        ->latest()
    );
}

use Illuminate\Database\Eloquent\Builder;

Builder::macro('addSubSelect', function ($column, $query) {
    if (is_null($this->getQuery()->columns)) {
        $this->select($this->getQuery()->from.'.*');
    }

    return $this->selectSub($query->limit(1)->getQuery(), $column);
});

# more improvement
$customers = Customer::with('company')
    ->withLastInteraction()
    ->orderByName()
    ->paginate();

public function lastInteraction() {
    return $this->hasOne(Interaction::class, 'id', 'last_interaction_id');
}

public function scopeWithLastInteraction($query) {
    $query->addSubSelect('last_interaction_id', Interaction::select('id')
        ->whereRaw('customer_id = customers.id')
        ->latest()
    )->with('lastInteraction');
}

<td>
    {{ $customer->lastInteraction->created_at->diffForHumans() }}
    <span class="text-secondary">({{ $customer->lastInteraction->type }})</span>
</td>

// Remove last_interaction_date cast:
protected $casts = [
    'birth_date' => 'date',
];
```

## select column values by comma seperated
```php
>>> App\Product::selectRaw('GROUP_CONCAT(`image`)')->get()
```
