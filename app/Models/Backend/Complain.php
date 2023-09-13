<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use GlobalScope, AutoTimeStamp;
    protected $table ='complains';

    protected $guarded =['id'];
}
