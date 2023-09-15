<?php

namespace App\Models\Backend;

use App\Models\Branch;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class RentCollection extends Model
{
    protected $table = 'rent_collections';

    use GlobalScope, AutoTimeStamp;

    protected $guarded = ['id'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
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
