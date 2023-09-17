<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillType extends Model
{
    use GlobalScope, AutoTimeStamp, SoftDeletes;

    protected $table ='bill_types';

    protected $guarded =['id'];
}
