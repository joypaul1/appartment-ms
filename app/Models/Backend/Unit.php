<?php

namespace App\Models\Backend;

use App\Models\Branch;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit_configurations';

    use GlobalScope, AutoTimeStamp;

    protected $guarded = ['id'];
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }
}
