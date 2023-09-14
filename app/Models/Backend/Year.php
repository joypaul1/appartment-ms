<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;

class Year extends Model
{
    protected $table = 'year_configurations';

    use GlobalScope, AutoTimeStamp;

    protected $guarded = ['id'];
    use HasFactory;
}
