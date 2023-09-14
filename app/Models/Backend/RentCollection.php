<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class RentCollection extends Model
{
    protected $table ='rent_collections';

    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

}
