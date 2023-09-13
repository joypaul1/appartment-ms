<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owners';

    use GlobalScope, AutoTimeStamp;

    protected $guarded = ['id'];
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'owner_unit', 'unit_id');
    }
}
