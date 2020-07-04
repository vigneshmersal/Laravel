<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\QueryFilter;

class User extends Authenticatable implements MustVerifyEmail // vereify by email notify
{
    use Notifiable,
    SoftDeletes; // db - deleted_at column handling

    protected $fillable = [
        'name',
        'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $hidden = [ 'password' ];

    // integer, integer, real, float, double, decimal:<digits>, string, boolean, object, array, collection, date, datetime, and timestamp
    protected $casts = [
        'is_admin' => 'boolean', // 1 & 0 converted to true, false
        'status' => 'integer', // true, false convered to 1, 0
        'options' => 'array', // json to array access $options['key']
        'deleted_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     */
    protected $attributes = [
        'delayed' => false,
    ];

    // ->getTimestamp(); ->toDateTimeString();
    protected $dates = [ 'deleted_at' ];

    // disable - created_at , updated_at
    public $timestamps = false;

    protected $dateFormat = 'U';

    protected $primaryKey = 'flight_id';
    protected $keyType = 'string';

    public $incrementing = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    // use modal route key -> Route::get('/posts/{post:slug}', function (Post $post) { });
    public function getRouteKeyName() { return 'slug'; }

    // validate doctor role -> Route::get('/doctor/{doctor}', function (User $user) { });
    public function resolveRouteBinding($value, $field = null) {
        return $this->where(['name' => $value, 'role' => 'doctor'])->firstOrFail();
    }

    public function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    /*
    |--------------------------------------------------------------------------
    | Scope extract query
    |--------------------------------------------------------------------------
     */
    public function scopeAdmin($query) { return $query->where("role", "admin"); }
    public function scopeActive($query) { return $query->where('active', 1); }
    public function scopeRegisteredWithinDays($query, $days) {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /*
    |--------------------------------------------------------------------------
    | Scope check
    |--------------------------------------------------------------------------
     */
    public function scopeIsAdmin() { return $this->role == "admin"; }

    /*
    |--------------------------------------------------------------------------
    | Scope Filter
    |--------------------------------------------------------------------------
    */
    public function scopeFilter($query, QueryFilter $filters) { return $filters->apply($query); }

    /*
    |--------------------------------------------------------------------------
    | Get methods
    |--------------------------------------------------------------------------
     */
    public function getFullNameAttribute() { return "{$this->first_name} {$this->last_name}"; }
    public function getActiveAttribute() { return $this->status == 1 ? 'Active' : 'InActive'; }
    public function getIsAdminAttribute() {
        return $this->roles()->where('id', 1)->exists();
    }
     public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Set method
    |--------------------------------------------------------------------------
    */
    public function setFirstNameAttribute($v) {
        $this->attributes['first_name'] = strtolower($v);
    }
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    public function generateToken() {
        $this->api_token = str_random(60);
        $this->save();
        return $this->api_token;
    }

    /*
    |--------------------------------------------------------------------------
    | Eloquent relationship
    |--------------------------------------------------------------------------
     */

    /*
    |--------------------------------------------------------------------------
    | hasOne Relationship
    |--------------------------------------------------------------------------
    */
    public function doctor() {
        return $this->hasOne('App\Doctor');
    }

    /*
    |--------------------------------------------------------------------------
    | belongsToMany Relationship
    |--------------------------------------------------------------------------
    */
    public function roles() {
        return $this->belongsToMany('App\Role')
            ->withPivot(['before', 'after'])
            ->withTimestamps() // get pivot table timestamps
            ->latest() // orderBy('created_at')
            ->latest('pivot_updated_at'); // orderBy pivot table updated_at

    }

    function update() {
        $this->adjustments()->attach(Auth::id(), $this->getDiff());
    }

    function getDiff() {
        $changed = $this->getDirty();
        $before = json_encode(array_intersect_key($this->fresh()->toArray(), $changed));
        $after = json_encode($changed);
        return compact('before', 'after');
    }

    /*
    |--------------------------------------------------------------------------
    | functions
    |--------------------------------------------------------------------------
    */
    protected static function uploadAvatar($image) {
        $filename = $image->getClientOriginalName();
        (new self())->deleteOldImage();
        $image->storeAs('img/adminuser', $filename, 'public');
        auth()->user()->update(['avatar' => $filename]);
    }

    protected function deleteOldImage() {
        if($this->avatar) {
            Storage::delete('public/img/adminuser', $this->avatar);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Booting Methods
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        // observable events:creating, created, updating, updated, deleting,
        // deleted, saving, saved, restoring, restored
        static::event(function ($model) {
            // return false to halt
        });

        static::updating(function ($model) {
            // which fields where updated
            $dirty = $record->getDirty();

            foreach ($dirty as $field => $newdata) {
                // getOriginal old date
                $olddata = $record->getOriginal($field);

                if ($olddata != $newdata) {
                    // Do what it takes here :)
                }
            }
            return true;
        });
    }
}
