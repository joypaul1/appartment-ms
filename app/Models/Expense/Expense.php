<?php

namespace App\Models\Expense;

use App\Models\Account\AccountLedger;
use App\Models\DailyAccountTransaction;
use App\Models\PaymentSystem;
use App\Models\Transaction\CashFlow;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use AutoTimeStamp, GlobalScope;

    protected $guarded = ['id'];

    public function typeOfExpense()
    {
        return $this->belongsTo(AccountLedger::class, 'expense_type_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id');
    }
    public function paymentLedger()
    {
        return $this->belongsTo(AccountLedger::class, 'ledger_id');
    }

    /**
     * Get all of the Purchase's daybook transaction.
     */
    public function dailyTransactions()
    {
        return $this->morphMany(DailyAccountTransaction::class, 'transactionable');
    }
    /**
     * Get all of the Purchase's cash flow transaction.
     */
    public function cashflowTransactions()
    {
        return $this->morphMany(CashFlow::class, 'cashflowable');
    }
}
