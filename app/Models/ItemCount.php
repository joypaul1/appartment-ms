<?php

namespace App\Models;

use App\Models\Item\Item;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class ItemCount extends Model
{
    use AutoTimeStamp;
    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
