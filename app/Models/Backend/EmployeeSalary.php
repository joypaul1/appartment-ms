<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $table ='employee_salaries';

    use GlobalScope, AutoTimeStamp;
    protected $guarded =['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
    public function month()
    {
        return $this->belongsTo(MonthConfiguration::class);
    }

}
