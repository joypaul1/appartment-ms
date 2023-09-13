<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table ='employees';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];
}
