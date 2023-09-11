<?php

namespace App\Models\lab;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class LabTestPurchaseItem extends Model
{
    use AutoTimeStamp, GlobalScope;
    protected $table = 'lab_test_purchase_items';

    protected $guarded =['id'];

    /**
     * Get the pruchase that owns the PurchaseItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pruchase(): BelongsTo
    {
       return $this->belongsTo(LabTestPurchase::class, 'purchase_id', 'id');
    }
}
