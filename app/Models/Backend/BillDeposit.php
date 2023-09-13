<?php

namespace App\Models\Backend;


use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class BillDeposit extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $table ='bills';
    protected $guarded =['id'];
}
