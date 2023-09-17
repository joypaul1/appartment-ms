<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    protected $table = 'owners';

    use GlobalScope, AutoTimeStamp,SoftDeletes;

    protected $guarded = ['id'];

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'owner_unit', 'owner_id', 'unit_id');
    }
}
