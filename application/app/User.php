<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'status', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $hidden = [ 'password' ];
    protected $casts = [ 'deleted_at' => 'datetime' ];
    protected $dates = [ 'deleted_at' ];

    /*
    |--------------------------------------------------------------------------
    | Scope extract query
    |--------------------------------------------------------------------------
     */
    public function scopeAdmin($query) { return $query->where("role", "admin"); }

    /*
    |--------------------------------------------------------------------------
    | Scope check
    |--------------------------------------------------------------------------
     */
    public function scopeIsAdmin() { return $this->role == "admin"; }

    /*
    |--------------------------------------------------------------------------
    | Get methods
    |--------------------------------------------------------------------------
     */
    public function getActiveAttribute() { return $this->status == 1 ? 'Active' : 'InActive'; }

    /*
    |--------------------------------------------------------------------------
    | Eloquent relationship
    |--------------------------------------------------------------------------
     */
    public function doctor() { return $this->hasOne('App\Doctor'); }
}
