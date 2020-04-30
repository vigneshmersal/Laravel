<?php

namespace App\Traits;

trait ModelTrait
{
	public function scopeActive($query)
	{
		return $query->where('status', true);
	}
}
