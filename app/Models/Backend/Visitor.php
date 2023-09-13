<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table ='visitors';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
