<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Carbon\Carbon;

class DateTimeCast implements CastsAttributes
{
	/**
	 * Cast the given value.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  string  $key
	 * @param  mixed  $value
	 * @param  array  $attributes
	 * @return mixed
	 */
	public function get($model, $key, $value, $attributes)
	{
		if ($value) {
			$value = Carbon::parse($value)
				->format(config('panel.date_format').' '.config('panel.time_format'));
			if ($value) {
				return strtotime($value) < 0 ? null : $value;
			}
		}
		return null;
	}

	/**
	 * Prepare the given value for storage.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  string  $key
	 * @param  array  $value
	 * @param  array  $attributes
	 * @return mixed
	 */
	public function set($model, $key, $value, $attributes)
	{
		if ($value) {
			return Carbon::parse($value)->format('Y-m-d H:i:s');
		}
		return null;
	}
}
