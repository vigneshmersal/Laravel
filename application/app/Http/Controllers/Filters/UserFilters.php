<?php
# other samples - https://m.dotdev.co/writing-advanced-eloquent-search-query-filters-de8b6c2598db

namespace App\Http\Controllers\Filters;
use App\Traits\QueryFilter;

# model
public function scopeFilter($query, QueryFilter $filters) {
    return $filters->apply($query);
}

# Controller
public function index(UserFilters $filters)
{
    return User::filter($filters)->get();
}

# UserFilters
class UserFilters extends QueryFilter
{

	public function popular($order = 'desc') {
		return $this->builder->orderBy('column', $order);
	}

	public function difficulty($level) {
		return $this->builder->where('difficulty', $level)->get();
	}
}
