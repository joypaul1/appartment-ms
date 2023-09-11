<?php

namespace App\Http\Controllers\Backend\Dialysis\Item;

use Illuminate\Http\Request;
use App\Imports\ImportItem;
use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\WareHouse;
use App\Models\Item\Category;
use App\Models\Item\Item;
use App\Models\Item\Strength;
use App\Models\Item\Subcategory;
use App\Models\Item\Type;
use App\Models\Item\Unit;
use App\Models\ItemCount;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importView()
    {
        return view('import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        // return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        //Set maximum php execution time
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);
        $parsed_array = Excel::toArray([], request()->file('file'));

        //Remove header value
        $imported_data = array_splice($parsed_array[0], 1);

        // $total_values = count($imported_data);

        $is_valid = true;
        $error_msg = '';
        $row_no = '';
        foreach ($imported_data as $key => $value) {
            $row_no = $key + 1;
            try {
                DB::beginTransaction();
                if (isset($value[0]) && empty($value[0])) {
                    $is_valid = false;
                    $error_msg = 'Item name not found.' . $row_no;
                    break;
                }
                if (isset($value[5]) && empty($value[5])) {
                    $is_valid = false;
                    $error_msg = 'Item Unit name not found' . $row_no;
                    break;
                }
                if (isset($value[6]) && empty($value[6])) {
                    $is_valid = false;
                    $error_msg = 'Item Unit name not found' . $row_no;
                    break;
                }
                if (isset($value[13]) && empty($value[13])) {
                    $is_valid = false;
                    $error_msg = 'Item Purchase Price not found' . $row_no;
                    break;
                }
                if (isset($value[14]) && empty($value[14])) {
                    $is_valid = false;
                    $error_msg = 'Item Sell Price not found' . $row_no;
                    break;
                }

                if (!$is_valid) {
                    throw new \Exception($error_msg);
                }

                $profit = 0;
                $profitPercentage = 0;
                $purchasePrice =  $value[13];
                $sellPrice =  $value[14];
                $profit = $sellPrice - $purchasePrice;
                if ($profit > 0) {
                    $profitPercentage = ($profit / $purchasePrice) * 100;
                }


                $item = Item::create([
                    'name'              => $value[0],
                    'sku'               => $value[1] ?? null,
                    'unit_id'           => Unit::updateOrCreate(['name' => $value[5]])->id,
                    'product_type'      => 'single',
                    'strength_id'       => isset($value[4]) ? Strength::updateOrCreate(['name' => $value[4]])->id : null,
                    'type_id'           => Type::updateOrCreate(['name' => $value[2]])->id,
                    'category_id'       => 2,
                    'subcategory_id'    => Subcategory::updateOrCreate(['category_id' => 2, 'name' => $value[7]])->id,
                    'up_before_tax'     => $value[13],
                    'tax_rate'          => 0,
                    'profit_percent'    => $profitPercentage,
                    'up_after_tax'      => $value[13],
                    'sell_price'        => $value[14],
                    'description'       => $value[15],
                    'alert_quantity'    => 10,
                    'created_at'        => date("Y-m-d H:i:s"),
                    'updated_at'        => date("Y-m-d H:i:s"),
                    'created_by'        => auth('admin')->id()
                ]);

                if (isset($value[11]) &&  $value[11] > 0) {
                    InventoryItem::create([
                        'warehouses_id' => WareHouse::first()->id,
                        'item_id' => $item->id,
                        'date' => date('Y-m-d'),
                        'previous_qty' => $value[11],
                    ]);

                    ItemCount::updateOrCreate([
                        'item_id' => $item->id
                    ], [
                        'in_qty' => $value[11]
                    ]);


                    // Check if a record with the same item_id and date exists in the table
                    $existingRecord = DB::table('day_wise_stock')
                        ->where('item_id', $item->id)
                        ->where('date', date('Y-m-d'))
                        ->first();
                    // dd($existingRecord );
                    if ($existingRecord) {
                        // If a record exists with the same item_id and date, increment the purchase_qty
                        DB::table('day_wise_stock')
                            ->where('item_id', $item->id)
                            ->where('date', date('Y-m-d'))
                            ->update([
                                'purchase_qty' => DB::raw('purchase_qty + ' . $value[11]),
                                'purchase_unit_price' => $item->up_after_tax
                            ]);
                    } else {
                        // If no record exists with the same item_id and date, insert a new record
                        DB::table('day_wise_stock')->insert([
                            'previous_qty' => $value[11],
                            'item_id' => $item->id,
                            'date' => date('Y-m-d'),
                            'purchase_unit_price' => $item->up_after_tax,
                        ]);
                    }
                }


                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                dd($ex->getMessage(), $ex->getCode(),  $row_no);
            }
        }
        dd('done');
        // return back();
    }
}

