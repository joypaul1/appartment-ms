<?php

namespace App\Http\Requests\Pathology\Lab;

use App\Helpers\InvoiceNumber;
use App\Models\Account\AccountLedger;
use App\Models\CommissionHistory;
use App\Models\CommissionLedger;
use App\Models\FinancialYearHistory;
use App\Models\lab\LabInvoice;
use App\Models\lab\LabInvoiceTestDetails;
use App\Models\lab\LabTest;
use App\Models\lab\LabTestInventoryItem;
use App\Models\lab\LabTestItemCount;
use App\Models\LedgerTransition;
use App\Models\PaymentSystem;
use App\Models\Reference;
use Carbon\Carbon;
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
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required',
            'labTest_id' => 'nullable|array',
            'labTest_id.*' => 'nullable|exists:lab_tests,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'reference_id' => 'nullable|exists:references,id',
            'test_price' => 'nullable|array',
            'test_price.*' => 'nullable|numeric',
            'testTube_id' => 'nullable|array',
            'testTube_id.*' => 'nullable|exists:lab_test_tubes,id',
            'testTube_price' => 'nullable|array',
            'testTube_price.*' => 'nullable|numeric',
            'testSubTotal' => 'nullable',
            'tubeSubTotal' => 'nullable',

        ];
    }
    public function getInvoiceNumber()
    {
        if (!LabInvoice::latest()->first()) {
            return 1;
        } else {
            return LabInvoice::latest()->first()->invoice_no + 1;
        }
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeData()
    {
        try {
            if (Str::replace(',', '', ($this->payable_amount + 0)) == Str::replace(',', '', ($this->paid_amount ?? 0 + 0))) {
                $payment_status = 'paid';
            } else {
                $payment_status = 'due';
            }
        //    dd($this->all());
            DB::beginTransaction();
            $data['invoice_no']         = (new InvoiceNumber)->invoice_num($this->getInvoiceNumber());
            $data['patient_id']         = $this->patient_id;
            $data['date']               = date('Y-m-d', strtotime($this->date)) . ' ' . date('h:i:s');
            $data['paid_amount']        = Str::replace(',', '', ($this->paid_amount));
            $data['payment_status']     = $payment_status;
            $data['subtotal_amount']    = Str::replace(',', '', ($this->payable_amount));
            $data['total_amount']       = Str::replace(',', '', ($this->payable_amount));
            $data['doctor_id']          = $this->doctor_id;
            $data['reference_id']       = $this->reference_id;
            $data['pathology_status']   = 'collection';
            $labInvoice                 = LabInvoice::create($data);

            if ($this->service_id) {
                foreach ($this->service_id as $key => $serviceId) {
                     $radioTest = LabTest::whereId($serviceId)->first();

                    //delivery time set
                    //12:00 am blood sample ar report 7:30 pm pabe( 7.30 hours pore report pabe), Except microbiology report.
                    if ($radioTest->time_type == "day") {
                        //carbon add day
                        if (date('H:i') <= "12:00") {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addDays($radioTest->time)->format('Y-m-d H:i:s'));
                        } else {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addDays($radioTest->time + 1)->format('Y-m-d H:i:s'));
                        }
                        $deliveryTime = $finalTime;
                    }
                    if ($radioTest->time_type == "hour") {
                        //carbon add time
                        if (date('H:i') <= "12:00") {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addHours($radioTest->time)->addMinutes(30)->format('Y-m-d H:i:s'));
                        } else {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addDays(1)->format('Y-m-d H:i:s'));
                        }
                        $deliveryTime = $finalTime;
                    }

                    $labInvoice->itemDetails()->create([
                        'service_name_id'   =>  $serviceId,
                        'qty'               =>  1.00,
                        'discount_type'     =>  $this['service_discount_type'][$key],
                        'discount'          =>  Str::replace(',', '', ($this['service_discount'][$key] ?? 0)),
                        'discount_amount'   =>  Str::replace(',', '', ($this['service_discount_amount'][$key] ?? 0)),
                        'price'             =>  Str::replace(',', '', ($this['service_test_price'][$key] ?? 0)),
                        'subtotal'          =>  Str::replace(',', '', ($this['service_subtotal'][$key] ?? 0)),
                        'status'            =>  'pending',
                        'delivery_time'     => $deliveryTime,

                    ]);
                }
            }


            if($this->labTest_id){

                foreach ($this->labTest_id as $key => $labTest) {
                    $labTest = LabTest::whereId($labTest)->first();

                    //delivery time set
                    //12:00 am blood sample ar report 7:30 pm pabe( 7.30 hours pore report pabe), Except microbiology report.
                    if ($labTest->time_type == "day") {
                        //carbon add day
                        if (date('H:i') <= "12:00") {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addDays($labTest->time)->format('Y-m-d h:i:s'));
                        } else {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addDays($labTest->time + 1)->format('Y-m-d H:i:s'));
                        }
                        $deliveryTime = $finalTime;
                    }
                    if ($labTest->time_type == "hour") {
                        //carbon add time
                        if (date('H:i') <= "12:00") {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addHours($labTest->time)->addMinutes(30)->format('Y-m-d H:i:s'));
                        } else {
                            $finalTime = (Carbon::parse($this->date . date('h:i a'))->addDays(1)->format('Y-m-d h:i:s'));
                        }
                        $deliveryTime = $finalTime;
                    }
                    // dd($deliveryTime);
                    //end delivery time set

                    if ($labTest->id == 319 || $labTest->id == 320) {
                        $labInvoice->labTestDetails()->create([
                            'status'            => 'pending',
                            'lab_test_id'       => $labTest->id,
                            'price'             => Str::replace(',', '', ($this->test_price[$key] ?? 0)),
                            'delivery_time'     => $deliveryTime,
                            'discount_type'     => $this->discount_type[$key],
                            'discount'          =>  Str::replace(',', '', ($this->discount[$key] ?? 0)),
                            'discount_amount'   =>  Str::replace(',', '', ($this->discount_amount[$key] ?? 0))  ,
                            'subtotal'          =>  Str::replace(',', '', ($this->subtotal[$key] ?? 0)),
                            'show_status'       => 0
                        ]);
                    }
                    else {
                        $labInvoice->labTestDetails()->create([
                            'status'            => 'pending',
                            'lab_test_id'       => $labTest->id,
                            'price'             => Str::replace(',', '', ($this->test_price[$key] ?? 0)),
                            'delivery_time'     => $deliveryTime,
                            'discount_type'     => $this->discount_type[$key],
                            'discount'          =>  Str::replace(',', '', ($this->discount[$key] ?? 0)),
                            'discount_amount'   =>  Str::replace(',', '', ($this->discount_amount[$key] ?? 0))  ,
                            'subtotal'          =>  Str::replace(',', '', ($this->subtotal[$key] ?? 0)),
                            'show_status' => 1

                        ]);
                    }
                }
            }


            if ($this->testTube_id) {
                // hasMany labTestTube data insert
                foreach ($this->testTube_id as $key => $testTube) {
                    $labInvoice->labTestTube()->create([
                        'lab_test_tube_id' => $testTube,
                        'price'             => Str::replace(',', '', ($this->testTube_price[$key] ?? 0)),
                            // /'price' => $this->testTube_price[$key],
                    ]);
                    // $labInvoice->orderItems()->create([
                    //     'order_id'      => $labInvoice->id,
                    //     'item_id'       => $testTube,
                    //     'qty'           => 1,
                    //     'unit_price'    => $this->testTube_price[$key],
                    //     'subtotal'      => $this->testTube_price[$key],
                    // ]);

                    $this->inventoryData($testTube, 1,  $this->testTube_price[$key]);
                }
            }
            if ($labInvoice->paid_amount > 0) {
                $labInvoice->paymentHistories()->create([
                    'ledger_id' => AccountLedger::first()->id,
                    'payment_method' => PaymentSystem::first()->id,
                    'date' => $this->date,
                    'note' => $this->payment_note,
                    'paid_amount' => Str::replace(',', '',  $labInvoice->paid_amount)
                ]);

                //<----start of cash flow Transition------->
                // cashflowTransactions
                $cashflowTransition = $labInvoice->cashflowTransactions()->create([
                    'url'               => "Backend\Pathology\LabTestController@show,['id' =>" . $labInvoice->id . "]",
                    'cashflow_type'     => 'labInvoice',
                    'description'       => 'labInvoice Item',
                    'date'              => $labInvoice->date,
                    'ledger_id'         => AccountLedger::first()->id,
                    'payment_method'    => PaymentSystem::first()->id,

                ]);
                // dd(  $cashflowTransition);

                // cashflowHistories
                $cashflowTransition->cashflowHistory()->create([
                    'debit' => Str::replace(',', '',  $labInvoice->paid_amount)
                ]);

                //<----end of cash flow Transition------->

                //<----start of daily book transaction------->
                // dailyTransition
                $dailyTransition = $labInvoice->dailyTransactions()->create([
                    'url'               => "Backend\Pathology\LabTestController@show,['id' =>" . $labInvoice->id . "]",
                    'description'       => 'labInvoice Item',
                    'transaction_type'  => 'labInvoice',
                    'date'              =>  $this->date,
                    'reference_no'      => $labInvoice->invoice_no,
                ]);

                //labInvoice full amount
                $dailyTransition->transactionHistories()->create([
                    'entry_name' => 'labInvoice Item',
                    'debit' => Str::replace(',', '',  $labInvoice->paid_amount),
                ]);



                // LedgerTransition --->increment costing
                LedgerTransition::updateOrCreate([
                    'ledger_id' => AccountLedger::first()->id,
                    'date'     => FinancialYearHistory::latest()->first()->start_date
                ], [
                    'debit' => DB::raw('debit +' . Str::replace(',', '',  $labInvoice->paid_amount))
                ]);
            }
            //commission system Transaction
            if ($this->reference_id) {
                $reference = Reference::whereId($this->reference_id)->first();
                if ($reference->commission > 0) {
                    $commissionTk = ($reference->commission / 100) * $this->payable_amount;
                    CommissionHistory::create([
                        'lab_invoice_id' => $labInvoice->id,
                        'reference_id' => $reference->id,
                        'commission' => $commissionTk
                    ]);
                    CommissionLedger::updateOrCreate([
                        'reference_id' => $this->reference_id,
                    ], [
                        'credit' => DB::raw('credit +' . Str::replace(',', '',  $commissionTk))
                    ]);
                }
            }
            //end commission system Transaction

            // dd($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage(), $e->getLine());
            return response()->json(['msg' => $e->getMessage(), $e->getLine(), 'status' => false], 400);
        }
        return response()->json(['data' => $labInvoice->id, 'status' => true], 200);
    }





    public function paymentStore($labInvoice, $request)
    {
        if ($request->paid_amount < 0 && !$request->paid_amount) {
            return response()->json(['msg' => 'Paid amount can not be negative or 0', 'status' => false], 400);
        }
        try {
            DB::beginTransaction();
            if (Str::replace(',', '', ($request->payable_amount + 0)) == Str::replace(',', '', ($request->paid_amount ?? 0 + 0))) {
                $payment_status = 'paid';
            } else {
                $payment_status = 'due';
            }
            $labInvoice->update([
                'paid_amount'   => $labInvoice->paid_amount + Str::replace(',', '',  $request->paid_amount ?? +0),
                'payment_status' => $payment_status
            ]);

            $labInvoice->paymentHistories()->create([
                'ledger_id' => AccountLedger::first()->id,
                'payment_method' => PaymentSystem::first()->id,
                'payment_system_id' => PaymentSystem::first()->name,
                'date' => $request->date,
                'note' => $request->payment_note,
                'paid_amount' => Str::replace(',', '',  $request->paid_amount),
                'payment_received_id' => auth('admin')->id(),
            ]);

            //<----start of cash flow Transition------->
            // cashflowTransactions
            $cashflowTransition = $labInvoice->cashflowTransactions()->create([
                'url'               => "Backend\Pathology\LabTestController@show,['id' =>" . $labInvoice->id . "]",
                'cashflow_type'     => 'labInvoice',
                'description'       => 'labInvoice Payment',
                'date'              => $request->date,
                'ledger_id'         => AccountLedger::first()->id,
                'payment_method'    => PaymentSystem::first()->id,

            ]);
            // dd(  $cashflowTransition);

            // cashflowHistories
            $cashflowTransition->cashflowHistory()->create([
                'debit' => Str::replace(',', '',  $request->paid_amount)
            ]);

            //<----end of cash flow Transition------->

            //<----start of daily book transaction------->
            // dailyTransition
            $dailyTransition = $labInvoice->dailyTransactions()->create([
                'url'               => "Backend\Pathology\LabTestController@show,['id' =>" . $labInvoice->id . "]",
                'description'       => 'labInvoice Item',
                'transaction_type'  => 'labInvoice',
                'date'              =>  $request->date,
                'reference_no'      => $labInvoice->invoice_no,
            ]);

            //labInvoice full amount
            $dailyTransition->transactionHistories()->create([
                'entry_name' => 'labInvoice Item',
                'debit' => Str::replace(',', '',  $request->paid_amount),
            ]);



            // LedgerTransition --->increment costing
            LedgerTransition::updateOrCreate([
                'ledger_id' => AccountLedger::first()->id,
                'date'     => FinancialYearHistory::latest()->first()->start_date
            ], [
                'debit' => DB::raw('debit +' . Str::replace(',', '',  $request->paid_amount))
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => $e->getMessage(), $e->getLine(), 'status' => false], 400);
        }
        return response()->json(['data' => $labInvoice->id, 'status' => true], 200);
    }



    function inventoryData($item_id, $get_qty, $sell_price)
    {

        // Check if a record with the same item_id and date exists in the table
        $existingRecord = DB::table('lab_test_day_wise_stock')
            ->where('item_id',  $item_id)
            ->where('date', date('Y-m-d'))
            ->first();
        if ($existingRecord) {
            // If a record exists with the same item_id and date, increment the purchase_qty
            DB::table('lab_test_day_wise_stock')
                ->where('item_id',  $item_id)
                ->where('date', date('Y-m-d'))
                ->update([
                    'sell_unit_price' => $sell_price,
                    'sell_qty' => DB::raw('sell_qty + ' . $get_qty),
                ]);
        } else {
            // If no record exists with the same item_id and date, insert a new record
            DB::table('lab_test_day_wise_stock')->insert([
                'previous_qty' =>   LabTestItemCount::whereId($item_id)->first()->available_qty ?? 0,
                'item_id' =>  $item_id,
                'date' => date('Y-m-d'),
                'sell_qty' => $get_qty,
                'sell_unit_price' => $sell_price,
            ]);
        }
        LabTestItemCount::updateOrCreate([
            'item_id' => $item_id,
        ], [
            'out_qty' => DB::raw('out_qty +' . $get_qty),
        ]);

        $this->inventoryQty($item_id, $get_qty);
    }

    function inventoryQty($item_id, $get_qty)
    {
        $sell_qty = $get_qty;
        $data = LabTestInventoryItem::whereItemId($item_id)->where('available_qty', '>', 0)->orderBy('id', 'asc')->first();
        if ($data->available_qty >= $sell_qty) {
            $data->update([
                'sell_qty' => DB::raw('sell_qty +' . $sell_qty)
            ]);
        } else {
            $rest_qty = $sell_qty - $data->available_qty;
            $data->update([
                'sell_qty' => DB::raw('sell_qty +' . $data->available_qty)
            ]);
            $this->inventoryQty($item_id, $rest_qty);
        }
    }
}
