<?php

namespace App\Models\Service;

use App\Models\PaymentSystem;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;

class ServiceInvoicePaymentHistory extends Model
{
    use GlobalScope, AutoTimeStamp;
    protected $guarded = ['id'];

    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id', 'id');
    }
}
