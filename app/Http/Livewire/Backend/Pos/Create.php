<?php

namespace App\Http\Livewire\Backend\Pos;

use App\Models\Item\Brand;
use App\Models\Item\Item;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Helpers\InvoiceNumber;
use App\Models\Account\AccountLedger;
use App\Models\FinancialYearHistory;
use App\Models\Inventory\InventoryItem;
use App\Models\Item\Subcategory;
use App\Models\ItemCount;
use App\Models\LedgerTransition;
use App\Models\PaymentSystem;
use Illuminate\Support\Str;

class Create extends Component
{
    public $brand_id, $userId, $subcategory_id, $userDetails, $subcategories, $brands, $total, $subTotal, $discount, $discount_type, $discount_amount, $shippingCost = 0, $invoice_url = null, $tax_amount = 0, $tax_percent, $cartSubTotal = 0, $itemCount = 0, $itemQty = 0, $cartTotal = 0;
    public $discountModal = 0;
    public $patientModal = false;
    public $basket = array();

    protected $listeners = ['updateQty'];


    public function mount()
    {
        $this->tax_percent      = 0;
        $this->userId           = 1;
        $this->subcategories    = Subcategory::active()->where('category_id', 1)->select('id', 'name', 'status')->get();
        $this->brands           = Brand::active()->select('id', 'name', 'status')->get();
    }
    public function render()
    {
        return view('livewire.backend.pos.create')
            ->with('basket', $this->basket)
            ->with('items', $this->itemQuery())
            ->extends('backend.layout.posApp')
            ->section('content');
    }



    public function getInvoiceNumber()
    {
        if (!Order::latest()->first()) {
            return 1;
        } else {
            return Order::latest()->first()->invoice_number + 1;
        }
    }

    public function storeData($data)
    {
        if ($this->userId == null) {
            $this->userId  = 1;
        }
        if (count($this->basket) == 0) {
            return  $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Your Item Is Empty']);
        }
        $order  = [];
        try {
            DB::beginTransaction();

            //create order
            $order = Order::create([
                'invoice_number'    => (new InvoiceNumber)->invoice_num($this->getInvoiceNumber()),
                'patient_id'        => $this->userId,
                'date'              => date('Y-m-d'),
                'order_type'        => 'pharmacy',
                'sub_total'         => $this->cartSubTotal,
                'total'             => $this->cartTotal,
                'tax'               => $this->tax_percent,
                'tax_amount'        => $this->tax_amount,
                'discount'          => $this->discount,
                'discount_type'     => $this->discount_type,
                'discount_amount'   => $this->discount_amount,
            ]);
            // dd($order);

            //order current status
            $order->orderStatus()->create([
                'status' => $data,
                'date' => date('Y-m-d h:i:s'),
            ]);

            //order items
            foreach ($this->basket as $itemId => $cartItem) {
                $order->orderItems()->create([
                    'order_id'      => $order->id,
                    'item_id'       => $itemId,
                    'qty'           => $cartItem['qty'],
                    'unit_price'    => $cartItem['sell_price'],
                    'subtotal'      => $cartItem['subtotal'],
                ]);
                $this->inventoryData($itemId, $cartItem['qty'], $cartItem['sell_price']);
            }
            $order->paymentHistories()->create([
                'ledger_id'             => AccountLedger::first()->id,
                'payment_method'        => PaymentSystem::first()->name,
                'payment_system_id'     => PaymentSystem::first()->id, //6
                'date'                  => date('Y-m-d'),
                'note'                  => 'Invoice Create',
                'paid_amount'           => Str::replace(',', '', $this->cartTotal),
                'payment_received_id'   => auth('admin')->id(),
            ]);

            //<----start of cash flow Transition------->
            $cashflowTransition = $order->cashflowTransactions()->create([
                'url'               => "Backend\Pos\PosController@show,['id' =>" . $order->id . "]",
                'cashflow_type'     => 'Pharmacy Invoice',
                'description'       => 'Pharmacy Invoice Create',
                'date'              => date('Y-m-d'),
                'ledger_id'         => AccountLedger::first()->id,
                'payment_method'    => PaymentSystem::first()->id,
            ]);


            // cashflowHistories
            $cashflowTransition->cashflowHistory()->create([
                'debit' => Str::replace(',', '', $this->cartTotal)
            ]);
            //<----end of cash flow Transition------->

            //<----start of dailyTransition book transaction------->
            $dailyTransition = $order->dailyTransactions()->create([
                'url'               =>  "Backend\Pos\PosController@show,['id' =>" . $order->id . "]",
                'description'       => 'Pharmacy Invoice Create',
                'transaction_type'  => 'Pharmacy Invoice',
                'date'              =>  date('Y-m-d'),
                'reference_no'      =>  $order->invoice_number,
            ]);

            //credit transactionHistories // Dialysis Invoice increase
            $dailyTransition->transactionHistories()->create([
                'entry_name' => 'Pharmacy Invoice Created',
                'credit'      => Str::replace(',', '', $this->cartTotal),
            ]);

            //debit transactionHistories // amount increase
            $dailyTransition->transactionHistories()->create([
                'entry_name' => AccountLedger::first()->name,
                'debit' => Str::replace(',', '', $this->cartTotal),
            ]);

            // LedgerTransition --->increment income
            LedgerTransition::updateOrCreate([
                'ledger_id' => AccountLedger::first()->id,
                'date'     => FinancialYearHistory::latest()->first()->start_date
            ], [
                'debit' => DB::raw('debit+' . Str::replace(',', '', $this->cartTotal))
            ]);

            $this->invoice_url = route('backend.pos-pdf.show', $order->id);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return   $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => $ex->getMessage()]);
        }

        $this->resetData();  // clear cart
        return  $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Successfully Done']);
    }

    function inventoryData($item_id, $get_qty, $sell_price)
    {

        // Check if a record with the same item_id and date exists in the table
        $existingRecord = DB::table('day_wise_stock')
            ->where('item_id',  $item_id)
            ->where('date', date('Y-m-d'))
            ->first();
        if ($existingRecord) {
            // If a record exists with the same item_id and date, increment the purchase_qty
            DB::table('day_wise_stock')
                ->where('item_id',  $item_id)
                ->where('date', date('Y-m-d'))
                ->update([
                    'sell_unit_price' => $sell_price,
                    'sell_qty' => DB::raw('sell_qty + ' . $get_qty),
                ]);
        } else {
            // If no record exists with the same item_id and date, insert a new record
            DB::table('day_wise_stock')->insert([
                'previous_qty' =>   ItemCount::whereId($item_id)->first()->available_qty ?? 0,
                'item_id' =>  $item_id,
                'date' => date('Y-m-d'),
                'sell_qty' => $get_qty,
                'sell_unit_price' => $sell_price,
            ]);
        }
        ItemCount::updateOrCreate([
            'item_id' => $item_id,
        ], [
            'out_qty' => DB::raw('out_qty +' . $get_qty),
        ]);

        $this->inventoryQty($item_id, $get_qty);
    }

    function inventoryQty($item_id, $get_qty)
    {
        $sell_qty = $get_qty;
        $data = InventoryItem::whereItemId($item_id)->where('available_qty', '>', 0)->orderBy('id', 'asc')->first();
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
    public function itemQuery()
    {
        return Item::active()->where('category_id', 1)
            ->when($this->brand_id, function ($query) {
                $query->where('brand_id', $this->brand_id);
            })
            ->when($this->subcategory_id, function ($query) {
                $query->where('subcategory_id', $this->subcategory_id);
            })->with('itemCount')
            ->paginate(25);
    }
    public function addToCard($itemId)
    {
        $item  = Item::whereId($itemId)->with('itemCount')->first();
        if (optional($item->itemCount)->available_qty <= 0) {
            return  $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Sorry. Stock Not Available!']);
        }
        if (!$this->basket) {

            $this->basket = [
                $itemId => [
                    "name" => $item->name,
                    "qty" => 1,
                    "sell_price" => $item->sell_price,
                    "image" => $item->image,
                    "subtotal" => $item->sell_price,
                ]
            ];
        } else if (isset($this->basket[$itemId])) {
            $this->basket[$itemId]['qty']++;
            $this->basket[$itemId]['subtotal'] += $this->basket[$itemId]['sell_price'];
        } else {
            $this->basket[$itemId] = [
                "name" => $item->name,
                "qty" => 1,
                "sell_price" => $item->sell_price,
                "image" => $item->image,
                "subtotal" => $item->sell_price,
            ];
        }
        $this->cartCalculation();
    }

    public function qtyCalculation($method, $itemId)
    {
        if (isset($this->basket[$itemId])) {
            if ($method == "increment") {
                $this->basket[$itemId]['qty']++;
                $item  = Item::whereId($itemId)->with('itemCount')->first();
                if ($this->basket[$itemId]['qty'] > optional($item->itemCount)->available_qty) {
                    $this->basket[$itemId]['qty'] = round(optional($item->itemCount)->available_qty);
                    return  $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Sorry. Stock Not Available!']);
                }
                $this->basket[$itemId]['subtotal'] += $this->basket[$itemId]['sell_price'];
            } else {
                $this->basket[$itemId]['qty']--;
                $this->basket[$itemId]['subtotal'] -= $this->basket[$itemId]['sell_price'];
            }
            $this->cartCalculation();
            return true;
        }
    }

    public function deleteItem($itemId)
    {
        if (isset($this->basket[$itemId])) {
            unset($this->basket[$itemId]);
        }
        $this->cartCalculation();
        return true;
    }

    public function updateQty($value, $itemId)
    {
        $this->basket[$itemId]['qty']       = $value;
        $item  = Item::whereId($itemId)->with('itemCount')->first();
        if ($this->basket[$itemId]['qty'] > optional($item->itemCount)->available_qty) {
            $this->basket[$itemId]['qty'] = round(optional($item->itemCount)->available_qty);
            return  $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Sorry. Stock Not Available!']);
        }
        $this->basket[$itemId]['subtotal']  = $value * $this->basket[$itemId]['sell_price'];
        $this->cartCalculation();
    }

    public function cartCalculation()
    {
        $this->cartSubTotal =  array_sum(array_column($this->basket, 'subtotal'));
        $this->tax_amount = ($this->cartSubTotal * $this->tax_percent) / 100;
        $this->cartTotal =  $this->cartSubTotal - $this->discount_amount - $this->tax_amount;
        $this->itemCount = count($this->basket);
        $this->itemQty = count($this->basket);
    }

    public function resetData()
    {
        $this->discount_type =
            $this->discount_amount =
            $this->discount =
            $this->total =
            $this->shippingCost =
            $this->tax_amount =
            $this->cartSubTotal =
            $this->itemCount =
            $this->itemQty =
            $this->cartTotal
            = 0;
        $this->userDetails = null;
        $this->userId = null;
        $this->basket = array();
        return true;
    }


    public function discountCal($discount_type)
    {
        // discount type fixed or percentage calculation depends on subtotal
        $this->discount_type = $discount_type;
        if ($this->discount_type == 'fixed') {
            $this->discount_amount = $this->discount;
        } else {
            $this->discount_amount = ($this->cartSubTotal * $this->discount) / 100;
        }
        $this->cartCalculation();
    }


    function taxCalculation($tax)
    {

        $this->tax_percent = $tax;
        $this->tax_amount = ($this->cartSubTotal * $this->tax_percent) / 100;
    }
}
