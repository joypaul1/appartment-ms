<?php

namespace App\Models\Backend;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingInformation extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $table ='building_informations';

    protected $guarded =['id'];
}
