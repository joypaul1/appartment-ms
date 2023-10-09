<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Cache;

class Admin extends Authenticatable

{
    use AutoTimeStamp,GlobalScope, SoftDeletes;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'mobile','password','last_seen', 'image','branch_id', 'role_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }


    /**
     * Get all of the orders for the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'created_by', 'id');
    }
}
