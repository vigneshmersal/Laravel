## Add text based search
https://github.com/reinink/laracon2018
```php
<form class="input-group my-4" action="{{ route('customers') }}" method="get">
    <input type="hidden" name="order" value="{{ request('order') }}">
    <input type="text" class="w-50 form-control" placeholder="Search..." name="search" value="{{ request('search') }}">
    <select name="filter" class="custom-select">
        <option value="" selected>Filters...</option>
        <option value="birthday_this_week" {{ request('filter') === 'birthday_this_week' ? 'selected' : '' }}>Birthday this week</option>
    </select>
    <div class="input-group-append">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

$customers = Customer::with('company')
    ->withLastInteraction()
    // ->whereSearch($request->get('search'))
    ->whereFilters($request->only(['search', 'filter']))
    ->orderByField($request->get('order', 'name'))
    ->paginate();

public function scopeWhereSearch($query, $search)
{
    foreach (explode(' ', $search) as $term) {
        $query->where(function ($query) use ($term) {
            $query->where('first_name', 'ilike', '%'.$term.'%')
               ->orWhere('last_name', 'ilike', '%'.$term.'%')
               ->orWhereHas('company', function ($query) use ($term) {
                   $query->where('name', 'ilike', '%'.$term.'%');
               });
        });
    }
}

public function scopeWhereFilters($query, array $filters)
{
    $filters = collect($filters);

    $query->when($filters->get('search'), function ($query, $search) {
        $query->whereSearch($search);
    })->when($filters->get('filter') === 'birthday_this_week', function ($query, $filter) {
        $query->whereBirthdayThisWeek();
    });
}

use Illuminate\Support\Carbon;

public function scopeWhereBirthdayThisWeek($query)
{
    $start = Carbon::now()->startOfWeek();
    $end = Carbon::now()->endOfWeek();

    $dates = collect(new \DatePeriod($start, new \DateInterval('P1D'), $end))->map(function ($date) {
        return $date->format('md');
    });

    return $query->whereNotNull('birth_date')->whereIn(\DB::raw("to_char(birth_date, 'MMDD')"), $dates);
}
```

## Limit results to the current user's access
```php
use App\User;

$customers = Customer::with('company')
    ->withLastInteraction()
    ->whereFilters($request->only(['search', 'filter']))
    ->orderByField($request->get('order', 'name'))
    ->visibleTo(
        auth()->user()
        // User::where('name', 'Jonathan Reinink')->first()
    )
    ->paginate();

public function scopeVisibleTo($query, User $user)
{
    if ($user->is_admin) {
        return $query;
    }

    return $query->where('sales_rep_id', $user->id);
}
```
