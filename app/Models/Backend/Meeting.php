<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table ='management_committees';

    use GlobalScope, AutoTimeStamp;
    protected $guarded =['id'];

}
