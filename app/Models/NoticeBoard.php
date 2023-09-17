<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use GlobalScope, AutoTimeStamp;
    protected $table = 'notice';

    protected $guarded = ['id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
