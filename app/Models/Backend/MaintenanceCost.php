<?php

namespace App\Models\Backend;

use App\Models\Branch;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCost extends Model
{
    protected $table = 'daily_costs';

    use GlobalScope, AutoTimeStamp;

    protected $guarded = ['id'];

    public function month()
    {
        return $this->belongsTo(MonthConfiguration::class, 'month_id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
