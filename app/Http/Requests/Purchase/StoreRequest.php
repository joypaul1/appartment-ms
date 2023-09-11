<?php

namespace App\Http\Requests\Purchase;

use App\Helpers\Image;
use App\Helpers\InvoiceNumber;
use App\Models\Account\AccountLedger;
use App\Models\FinancialYearHistory;
use App\Models\Inventory\InventoryItem;
use App\Models\Item\Item;
use App\Models\ItemCount;
use App\Models\Ledger\SupplierLedger;
use App\Models\LedgerTransition;
use App\Models\Purchase\Purchase;
use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'purchase_date' => 'required',
            'receive_date' => 'required',
            'purchase_status' => 'required',
            'warehouse_id' => 'required',
            'pur_sub_total' => 'required',
            'pur_total' => 'required',
            'payment_amount' => 'nullable|numeric',
            'payment_method' => $this->getPaymentMethodRule(),
            'payment_account' => $this->getPaymentAccountRule()
        ];
        // return [
        //     'supplier_id' => 'required',
        //     'purchase_date' => 'required',
        //     'receive_date' => 'nullable',
        //     'purchase_status' => 'required',
        //     'warehouse_id' => 'required',
        //     // 'warehouse_id' => 'required',
        //     'item_id.*' => 'required',
        //     'purchase_qty.*' => 'required',
        //     'unit_id.*' => 'required',
        //     // 'unit_id.*' => 'required',
        //     'up_before_tax.*' => 'required',
        //     'subtotal_up_before_tax.*' => 'required',
        //     'tax_id.*' => 'required',
        //     'tax_rate.*' => 'required',
        //     'up_after_tax.*' => 'required',
        //     'subtotal_up_after_tax.*' => 'required',
        //     'profit_percent.*' => 'required',
        //     'un_sell_price.*' => 'required',
        //     'total_sell_price.*' => 'required',
        //     'discount_type' => 'nullable',
        //     'discount_amount' => 'nullable',
        //     'pur_dis_amount' => 'nullable',
        //     'pur_tax_id' => 'nullable',
        //     'pur_tax_amount' => 'nullable',
        //     'additional_notes' => 'nullable',
        //     'shipping_details' => 'nullable',
        //     'additional_shipping_charge' => 'nullable',
        //     'pur_sub_total' => 'required',
        //     'pur_total' => 'required',
        //     'payment_amount' => 'nullable',
        //     'paid_date' => 'nullable',
        //     'payment_method' => 'nullable',
        //     'payment_account' => 'nullable',
        //     'due_amount' => 'nullable',
        //     'payment_note' => 'nullable',
        //     'file' => 'nullable',

        // ];
    }
    protected function getPaymentMethodRule()
    {
        $rules = ['nullable'];

        if ($this->input('payment_amount') !== null && $this->input('payment_amount') != 0) {
            $rules[] = 'required';
        }

        return $rules;
    }

    protected function getPaymentAccountRule()
    {
        $rules = ['nullable'];

        if ($this->input('payment_amount') !== null && $this->input('payment_amount') != 0) {
            $rules[] = 'required';
        }

        return $rules;
    }
    public function getInvoiceNumber()
    {
        if (!Purchase::latest()->first()) {
            return 1;
        } else {
            return Purchase::latest()->first()->invoice_number + 1;
        }
    }

    public function storeData()
    {
        try {
            DB::beginTransaction();
            $data['invoice_number']     = (new InvoiceNumber)->invoice_num($this->getInvoiceNumber());
            $data['supplier_id']        = $this->supplier_id;
            $data['purchase_type']      = $this->purchase_type;
            $data['purchase_date']      = $this->purchase_date;
            $data['note']               = $this->additional_notes;
            $data['lot_number']         = $this->lot_number;
            $data['warehouse_id']       = $this->warehouse_id;
            $data['purchase_status']    = $this->purchase_status;
            $data['payment_status']     = ($this->pur_total > $this->payment_amount) ? 'Due' : 'Paid';
            $data['discount_type']      = $this->discount_type;
            $data['discount']           = Str::replace(',', '', ($this->discount_amount?? 0));
            $data['discount_amount']    = Str::replace(',', '', ($this->pur_dis_amount?? 0));
            $data['tax_amount']         = Str::replace(',', '', ($this->pur_tax_amount?? 0));
            $data['discount']           = Str::replace(',', '', ($this->discount_amount?? 0));
            $data['tax_id']             = $this->pur_tax_id;
            $data['paid_amount']        = Str::replace(',', '', ($this->payment_amount?? 0));
            $data['subtotal_amount']    = Str::replace(',', '', ($this->pur_sub_total?? 0));
            $data['total_amount']       = Str::replace(',', '', ($this->pur_total?? 0));

            $purchase = Purchase::create($data); //data created here
            // item data
            for ($i = 0; $i < count($this->item_id); $i++) {

                $purchase->purchaseItems()->create([
                    'item_id'                   => $this->item_id[$i],
                    'purchase_qty'              => Str::replace(',', '', ($this->purchase_qty[$i] ?? 0)),
                    'up_before_tax'             => Str::replace(',', '', ($this->up_before_tax[$i] ?? 0)),
                    'subtotal_up_before_tax'    => Str::replace(',', '', ($this->subtotal_up_before_tax[$i] ?? 0)),
                    'tax_id'                    => $this->tax_id[$i] ?? null,
                    'tax_rate'                  => Str::replace(',', '', ($this->tax_rate[$i] ?? 0)),
                    'up_after_tax'              => Str::replace(',', '', ($this->up_after_tax[$i] ?? 0)),
                    'subtotal_up_after_tax'     => Str::replace(',', '', ($this->subtotal_up_after_tax[$i] ?? 0)),
                    'un_sell_price'             => Str::replace(',', '', ($this->un_sell_price[$i] ?? 0)),
                    'total_sell_price'          => Str::replace(',', '', ($this->total_sell_price[$i] ?? 0)),
                    'expire_date'               => $this->expire_date[$i] ?? null,
                ]);


                Item::whereId($this->item_id[$i])->update([
                    'unit_id'                   => $this->unit_id[$i] ?? null,
                    'up_before_tax'             => Str::replace(',', '', ($this->up_before_tax[$i] ?? 0)),
                    'tax_id'                    => $this->tax_id[$i] ?? null,
                    'tax_rate'                  => Str::replace(',', '', ($this->tax_rate[$i] ?? 0)),
                    'up_after_tax'              => Str::replace(',', '', ($this->up_after_tax[$i] ?? 0)),
                    'profit_percent'            => Str::replace(',', '', ($this->profit_percent[$i] ?? 0)),
                    'sell_price'                => Str::replace(',', '', ($this->un_sell_price[$i] ?? 0)),
                ]);


                // Check if a record with the same item_id and date exists in the table
                $existingRecord = DB::table('day_wise_stock')
                    ->where('item_id',  $this->item_id[$i])
                    ->where('date', $this->purchase_date)
                    ->first();
                if ($existingRecord) {
                    // If a record exists with the same item_id and date, increment the purchase_qty
                    DB::table('day_wise_stock')
                        ->where('item_id',  $this->item_id[$i])
                        ->where('date', $this->purchase_date)
                        ->update([
                            'purchase_qty' => DB::raw('purchase_qty + ' . str::replace(',', '', ($this->purchase_qty[$i] ?? 0))),
                            'purchase_unit_price' => str::replace(',', '', ($this->up_after_tax[$i] ?? 0))
                        ]);
                } else {
                    // If no record exists with the same item_id and date, insert a new record
                    DB::table('day_wise_stock')->insert([
                        'previous_qty' =>   ItemCount::whereId($this->item_id[$i])->first()->available_qty ?? 0,
                        'item_id' =>  $this->item_id[$i],
                        'date' => $this->purchase_date,
                        'purchase_qty' => str::replace(',', '', ($this->purchase_qty[$i] ?? 0)),
                        'purchase_unit_price' => str::replace(',', '', ($this->up_after_tax[$i] ?? 0)),
                    ]);
                }

                ItemCount::updateOrCreate([
                    'item_id' => $this->item_id[$i] ?? null,
                ], [
                    'in_qty' => DB::raw('in_qty +' . str::replace(',', '', ($this->purchase_qty[$i] ?? 0))),
                ]);

                InventoryItem::create([
                    'warehouses_id'         => $this->warehouse_id,
                    'item_id'               => $this->item_id[$i] ?? null,
                    'date'                  => $this->purchase_date,
                    'expire_date'           => $this->expire_date[$i] ?? null,
                    'pur_qty'               => DB::raw('pur_qty +' . str::replace(',', '', ($this->purchase_qty[$i] ?? 0))),
                ]);
            }

            //<----start of cash flow Transition------->

            if ($this->due_amount == 0) {
                // cashflowTransactions
                $cashflowTransition = $purchase->cashflowTransactions()->create([
                    'url'               => "Backend\Purchase\PurchaseController@show,['id' =>" . $purchase->id . "]",
                    'cashflow_type'     => 'Purchase',
                    'description'       => 'Purchase Item',
                    'date'              => $this->paid_date ?? $this->purchase_date,
                    'ledger_id'         => $this->payment_account,
                    'payment_method'    => $this->payment_method,
                ]);

                // cashflowHistories
                $cashflowTransition->cashflowHistory()->create([
                    'credit' => $this->payment_amount
                ]);
            }
            //<----end of cash flow Transition------->

            //<----start of daily book transaction------->

            // dailyTransition
            $dailyTransition = $purchase->dailyTransactions()->create([
                'url'               => "Backend\Purchase\PurchaseController@show,['id' =>" . $purchase->id . "]",
                'description'       => 'Purchase Item',
                'transaction_type'  => 'Purchase',
                'date'              => $this->paid_date ?? $this->purchase_date,
                'reference_no'      => $purchase->invoice_number,
            ]);

            //purchase full amount
            $dailyTransition->transactionHistories()->create([
                'entry_name' => 'Purchase Item',
                'debit' => $this->pur_total,
            ]);
            if ($this->pur_total && ($this->payment_amount > 0) && ($this->pur_total > $this->payment_amount)) { //partial due amount
                $dailyTransition->transactionHistories()->create([
                    'entry_name' => AccountLedger::find($this->payment_account)->name,
                    'credit' => $this->payment_amount,
                ]);
            }
            if (($this->pur_total && ($this->payment_amount == 0)) ||
                ($this->pur_total && ($this->payment_amount == null))
            ) { // full due amount
                $dailyTransition->transactionHistories()->create([
                    'entry_name' => Supplier::whereId($this->supplier_id)->first()->name,
                    'credit' => $this->pur_total,
                ]);
            }
            if (($this->pur_total > $this->payment_amount) && !($this->pur_total == $this->due_amount)
                && !($this->pur_total == $this->due_amount)
                && !($this->due_amount == 0)
            ) {  //partial due amount
                $dailyTransition->transactionHistories()->create([
                    'entry_name' => Supplier::whereId($this->supplier_id)->first()->name,
                    'credit' => $this->pur_total - $this->payment_amount ?? 0,
                ]);
            }
            if ($this->pur_total == $this->payment_amount) { // full paid
                $dailyTransition->transactionHistories()->create([
                    'entry_name' => AccountLedger::find($this->payment_account)->name,
                    'credit' => $this->pur_total,
                ]);
            }
            //<----end of daily book transaction------->

            //payment Histories
            if ($this->payment_amount && $this->payment_account && $this->payment_method) {
                $purchase->paymentHistories()->create([
                    'ledger_id' => $this->payment_account,
                    'payment_method' => $this->payment_method,
                    'date' => $this->paid_date,
                    'note' => $this->payment_note,
                    'paid_amount' => $this->payment_amount,
                ]);

                // LedgerTransition --->increment costing
                LedgerTransition::updateOrCreate([
                    'ledger_id' => $this->payment_account,
                    'date'     => FinancialYearHistory::latest()->first()->start_date
                ], [
                    'credit' => DB::raw('credit +' . $this->payment_amount)
                ]);
            }

            // SupplierLedger -->increment Creditor
            if ($this->pur_total > $this->payment_amount) {
                SupplierLedger::updateOrCreate([
                    'supplier_id' => $this->supplier_id,
                    'date'     => FinancialYearHistory::latest()->first()->start_date
                ], [
                    'credit' => DB::raw('credit +' . $this->pur_total - $this->payment_amount)
                ]);
            }

            // additional_shipping_charges
            if ($this->additional_shipping_charge) {
                $purchase->shipmentHistory()->create([
                    'date'      =>  $this->purchase_date,
                    'note'      =>  $this->additional_notes,
                    'details'   =>  $this->shipping_details,
                    'amount'    =>  $this->additional_shipping_charge,
                ]);
            }

            // file
            if ($this->hasFile('file')) {
                $image =  (new Image)->dirName('purchase')->file($this->file)
                    ->resizeImage(200, 200)
                    ->save();
                $purchase->documents()->create(['url' => $image]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return response()->json(['status' => false, 'msg' => $ex->getMessage()]);
        }
        return response()->json(['status' => true, 'msg' => 'Data Created Successfully.']);
    }
}
