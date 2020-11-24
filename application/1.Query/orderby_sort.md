
```php
latest() // order by created_at
oldest() // order by created_at
newest('updated_at')
reverse()
```

## orderBy
```php
orderBy('column', 'desc')
```

## sort
```php
sort() | sortDesc()
```

## sortBy
```php
sortBy($column) | sortByDesc($column)

# sortBy sub items count
sortBy(function ($item, $key) { return count($item['sub']); }); 

# Order by relationship
$users = User::with('latestPost')->get()->sortByDesc('latestPost.created_at');

# Order by Mutator
$users = User::get()->sortBy('full_name'); // first_name.' '.last_name
```

## raw
```php
->orderByRaw('YEAR(birth_date)')

# WhereIn(id) sort
->orderByRaw("field(id,".implode(',',$videoIds).")")
```

## Make all columns sortable
```php
<th><a class="{{ request('order', 'name') === 'name' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'name'] + request()->except('page')) }}">Name</a></th>
<th><a class="{{ request('order') === 'company' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'company'] + request()->except('page')) }}">Company</a></th>
<th><a class="{{ request('order') === 'birthday' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'birthday'] + request()->except('page')) }}">Birthday</a></th>
<th><a class="{{ request('order') === 'last_interaction' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'last_interaction'] + request()->except('page')) }}">Last Interaction</a></th>

$customers = Customer::with('company')
    ->withLastInteraction()
    ->orderByField($request->get('order', 'name'))
    ->paginate();

public function scopeOrderByField($query, $field)
{
    if ($field === 'name') {
        $query->orderByName();
    } elseif ($field === 'company') {
        $query->orderByCompany();
    } elseif ($field === 'birthday') {
        $query->orderByBirthday();
    } elseif ($field === 'last_interaction') {
        $query->orderByLastInteractionDate();
    }
}

public function scopeOrderByCompany($query)
{
    $query->join('companies', 'companies.id', '=', 'customers.company_id')->orderBy('companies.name');
}
// or
public function scopeOrderByCompany($query)
{
    $query->orderBySub(Company::select('name')->whereRaw('customers.company_id = companies.id'));
}
Builder::macro('orderBySub', function ($query, $direction = 'asc') {
    return $this->orderByRaw("({$query->limit(1)->toSql()}) {$direction}");
});

Builder::macro('orderBySubDesc', function ($query) {
    return $this->orderBySub($query, 'desc');
});

public function scopeOrderByBirthday($query)
{
    $query->orderbyRaw("to_char(birth_date, 'MMDD')");
}

public function scopeOrderByLastInteractionDate($query)
{
    $query->orderBySubDesc(Interaction::select('created_at')->whereRaw('customers.id = interactions.customer_id')->latest());
}
```
