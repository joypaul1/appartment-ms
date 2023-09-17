<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    protected $table ='notice_boards';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
