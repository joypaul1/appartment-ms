<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    protected $table ='member_types';

    use GlobalScope, AutoTimeStamp;
    protected $guarded =['id'];
}
