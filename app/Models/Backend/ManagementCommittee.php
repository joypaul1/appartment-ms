<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class ManagementCommittee extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $guarded = ['id'];
}
