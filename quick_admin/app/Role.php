<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Role extends Model
{
    use SoftDeletes;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    # -------------------------------------------------------------
	# Route
	# -------------------------------------------------------------
	const BLADE   = 'admin.roles';
	const TABLE   = 'roles';
	const ROUTE   = 'admin.roles';
	const LANG    = 'cruds.role.';
	const LANGF   = 'cruds.role.fields.';

	const INDEX   = 'role_access';
	const CREATE  = 'role_create';
	const EDIT    = 'role_edit';
	const SHOW    = 'role_show';
	const DESTROY = 'role_delete';
	// const RESTORE = 'role_restore';

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
