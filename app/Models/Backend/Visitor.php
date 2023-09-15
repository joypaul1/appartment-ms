<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table ='visitors';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

}
