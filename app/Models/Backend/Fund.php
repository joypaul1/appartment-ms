<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}

