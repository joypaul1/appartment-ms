<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table ='units';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
