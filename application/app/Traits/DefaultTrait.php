<?php

namespace App\Traits;

trait DefaultTrait
{
	protected static function boot()
	{
		parent::boot();

		static::creating(function ($obj) {
			if (\Auth::check()) {
				$obj->created_by = auth()->user()->name;
			} else {
				if ($obj->getTable() == "users") {
					$obj->created_by = $obj->name;
				} else {
					$obj->created_by = 'test';
				}
			}
		});

		static::updating(function ($obj) {
			if (!isset($obj->deleted_at)) {
				if (\Auth::check()) {
					$obj->updated_by = auth()->user()->name;
				} else {
					if ($obj->getTable() == "users") {
						$obj->updated_by = $obj->name;
					}
				}
			}
		});

		static::deleting(function ($obj) {
			$obj->deleted_by = auth()->user()->name;
			$obj->save();
		});
	}
}
