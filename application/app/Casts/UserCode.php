<?php
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;

/**
 * In model
 * protected $casts = [ 'user_id' => UserCode::class ];
 */
class UserCode extends CastsAttributes
{
	public function get($model, string $key, $value, array $attributes) {
		return "000".$value;
	}

	public function set($model, string $key, $value, array $attributes) {
		return Str::of($value)->trim(" ");
	}
}
