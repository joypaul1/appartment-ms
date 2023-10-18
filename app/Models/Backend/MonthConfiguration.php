<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthConfiguration extends Model
{
    protected $table = 'month_setups';

    use GlobalScope, AutoTimeStamp;
    protected $guarded = ['id'];
}
