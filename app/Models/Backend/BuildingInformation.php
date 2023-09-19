<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingInformation extends Model
{
    use GlobalScope, AutoTimeStamp,SoftDeletes;

    protected $table ='building_informations';

    protected $guarded =['id'];
}
