<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $table ='rent_configurations';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
