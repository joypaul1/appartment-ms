<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class BillType extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $table ='bill_types';

    protected $guarded =['id'];
}
