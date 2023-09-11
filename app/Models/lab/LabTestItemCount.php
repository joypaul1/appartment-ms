<?php

namespace App\Models\lab;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class LabTestItemCount extends Model
{
    protected $table = 'lab_test_item_counts';

    use AutoTimeStamp;
    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(LabTestTube::class, 'item_id', 'id');
    }
}
