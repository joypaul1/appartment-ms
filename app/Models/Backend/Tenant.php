<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table ='tenants';

    use GlobalScope, AutoTimeStamp;
    protected $guarded =['id'];

}
