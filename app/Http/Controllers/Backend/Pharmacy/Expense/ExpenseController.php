<?php

namespace App\Http\Controllers\Backend\Pharmacy\Expense;


use App\Helpers\InvoiceNumber;
use App\Http\Controllers\Controller;
use App\Models\Account\AccountLedger;
use App\Models\Doctor\Doctor;
use App\Models\Expense\Expense;
use App\Models\PaymentSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $expense = Expense::query()->where('category', 'Pharmacy');
        if ($request->filled('payment_method_id')) {
            $expense = $expense->where('payment_system_id', $request->payment_method_id);
        }
        if ($request->filled('payment_account_id')) {
            $expense = $expense->where('ledger_id', $request->payment_account_id);
        }
        if ($request->filled('expense_type_id')) {
            $expense = $expense->where('expense_type_id', $request->expense_type_id);
        }
        if ($request->start_date) {
            $expense = $expense->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date)));
        } else {
            $expense = $expense->whereDate('date', '>=', date('Y-m-d'));
        }
        if ($request->end_date) {
            $expense = $expense->whereDate('date', '<=',  date('Y-m-d', strtotime($request->end_date)));
        } else {
            $expense = $expense->whereDate('date', '>=', date('Y-m-d'));
        }
        $expense = $expense->with('typeOfExpense:id,name', 'paymentMethod:id,name', 'paymentLedger:id,name')->get();
        $payment_methods    = PaymentSystem::get(['id', 'name']);
        $expense_type       = AccountLedger::where('rec_pay', false)
            ->whereHas('accountGroup', function ($query) {
                return $query->whereHas('accountHead',  function ($accountHead) {
                    $accountHead->whereName('Expenses');
                });
            })
            ->get(['id', 'name']);
        $payment_accounts = AccountLedger::where('rec_pay', true)->get(['id', 'name']);
        return view('backend.pharmacy.expense.index', compact('payment_methods', 'payment_accounts', 'expense', 'expense_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expense_type       = AccountLedger::where('rec_pay', false)
            ->whereHas('accountGroup', function ($query) {
                return $query->whereHas('accountHead',  function ($accountHead) {
                    $accountHead->whereName('Expenses');
                });
            })
            ->get(['id', 'name']);
        $payment_methods    = PaymentSystem::get(['id', 'name']);
        $payment_accounts   = AccountLedger::where('rec_pay', true)->get(['id', 'name']);
        return view('backend.pharmacy.expense.create', compact('payment_methods', 'payment_accounts', 'expense_type'));
    }

    public function getInvoiceNumber()
    {
        if (!Expense::latest()->first()) {
            return 1;
        } else {
            return Expense::latest()->first()->invoice_number + 1;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data                       = $request->all();
            $data['invoice_number']     = (new InvoiceNumber)->invoice_num($this->getInvoiceNumber());
            $data['amount']             = Str::replace(',', '',  $request->paid_amount);
            $data['ledger_id']          = $request->payment_account;
            $data['payment_system_id']  = $request->payment_method;
            $data['payment_method']     = PaymentSystem::find($request->payment_method)->name;
            $data['date']               = date('Y-m-d h:i:s');
            $data['category']           ='Pharmacy';
            $expense                    = Expense::create($data);

            //<----start of cash flow Transition------->
            // cashflowTransactions
            $cashflowTransition = $expense->cashflowTransactions()->create([
                'url'               => "Expense\ExpenseController@show,['id' =>" . $expense->id . "]",
                'cashflow_type'     => 'Expense',
                'description'       => 'Expense Amount',
                'date'              => $expense->date,
                'ledger_id'         => $request->payment_account,
                'payment_method'    => $request->payment_method,

            ]);

            // cashflowHistories
            $cashflowTransition->cashflowHistory()->create([
                'credit' => Str::replace(',', '',  $expense->amount)
            ]);

            //<----end of cash flow Transition------->

            //<----start of daily book transaction------->
            // dailyTransition
            $dailyTransition = $expense->dailyTransactions()->create([
                'url'               => "Expense\ExpenseController@show,['id' =>" . $expense->id . "]",
                'description'       => 'Expense Amount',
                'transaction_type'  => 'Expense Payment',
                'date'              =>  $expense->date,
                'reference_no'      =>  $expense->id,
            ]);

            // full amount
            $dailyTransition->transactionHistories()->create([
                'entry_name' => 'Expense Amount',
                'credit' => Str::replace(',', '',  $expense->amount),
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->with(['error' => $ex->getMessage()]);
        }
        return redirect()->route('backend.pharmacy.expense.index')->with(['success' => 'Expense has been created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        // return view('backend.expense.show', compact('doctor', 'appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function invoice(Request $request)
    {

    }
}
