<?php

namespace App\Models\Backend;

use App\Models\Branch;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function owners()
    {
        return $this->belongsToMany(Owner::class, 'owner_unit');
    }
}
