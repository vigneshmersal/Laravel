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
	protected $algorithm;

	// Hash::class.':sha256',
	public function __construct($algorithm = null) {
        $this->algorithm = $algorithm;
    }

	public function get($model, string $key, $value, array $attributes) {
		return "000".$value;
		return json_decode($value, true);
		return is_null($this->algorithm) ? bcrypt($value) : hash($this->algorithm, $value);
	}

	public function set($model, string $key, $value, array $attributes) {
		return Str::of($value)->trim(" ");
		return json_encode($value);
	}
}
