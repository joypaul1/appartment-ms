<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    protected $table = 'rent_configurations';

    use GlobalScope, AutoTimeStamp,SoftDeletes;

    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}
