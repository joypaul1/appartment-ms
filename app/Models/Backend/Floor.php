<?php

namespace App\Models\Backend;

use App\Models\Branch;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $table ='floors';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

}
