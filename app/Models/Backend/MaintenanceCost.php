<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCost extends Model
{
    protected $table ='daily_costs';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
