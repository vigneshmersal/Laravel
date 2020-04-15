<?php

namespace App\Http\Controllers\Filters;

class ClassName extends QueryFilter
{

	public function popular($order = 'desc')
	{
		return $this->builder->orderBy('column', $order);
	}

	public function difficulty($level) {
		return $this->builder->where('difficulty', $level)->get();
	}
}
