<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCost extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
