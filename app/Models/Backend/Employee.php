<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    protected $table ='employees';

    use GlobalScope, AutoTimeStamp, SoftDeletes;

    protected $guarded =['id'];

    public function memberType()
    {
        return $this->belongsTo(MemberType::class, 'member_type_id');
    }
}
