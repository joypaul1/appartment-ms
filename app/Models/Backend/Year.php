<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
    protected $table = 'year_configurations';

    use GlobalScope, AutoTimeStamp, SoftDeletes;

    protected $guarded = ['id'];

}
