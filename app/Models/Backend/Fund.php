<?php

namespace App\Models\Backend;

use App\Models\Branch;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fund extends Model
{
    protected $table = 'funds';

    use GlobalScope, AutoTimeStamp,SoftDeletes;

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
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
