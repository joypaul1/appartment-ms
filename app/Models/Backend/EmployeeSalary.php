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
}
