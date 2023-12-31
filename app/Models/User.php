<?php

namespace App\Models;

use App\Traits\GlobalScope;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{

    use GlobalScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'present_address',
        'permanent_address',
        'note',
        'reference_id',
        'created_by',
        'updated_by',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
