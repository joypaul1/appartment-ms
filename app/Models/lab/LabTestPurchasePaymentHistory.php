<?php

namespace App\Models\lab;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;
class LabTestPurchasePaymentHistory extends Model
{
    use AutoTimeStamp,GlobalScope;
    protected $table ='lab_test_purchase_payment_histories';
    protected $guarded =['id'];
}
