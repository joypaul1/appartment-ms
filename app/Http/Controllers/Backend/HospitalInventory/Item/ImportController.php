<?php

namespace App\Http\Controllers\Backend\HospitalInventory\Item;



use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\WareHouse;
use App\Models\Item\Item;
use App\Models\Item\Strength;
use App\Models\Item\Subcategory;
use App\Models\Item\Type;
use App\Models\Item\Unit;
use App\Models\ItemCount;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Item\Brand;
use App\Models\Item\ChildCategory;
use App\Models\Item\GenericName;
use App\Models\Item\Rack;
use App\Models\Item\Row;

class ImportController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importView()
    {
        $titleName = 'Hospital Inventory Item/Product Import';
        $routeName = 'backend.hospital_inventory.itemConfig.itemImportStore';
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
        $user_id = auth('admin')->id();
        $dateTime = date("Y-m-d H:i:s");

        foreach ($imported_data as $key => $value) {


            //Check if any column is missing
            if (count($value) < 14) {
                $is_valid = false;
                $error_msg = 'Some of the columns are missing. Please, use latest CSV file template.';
                break;
            }

            $row_no = $key + 1;
            $product_array = [];
            $product_array['created_by'] = $user_id;
            $product_array['updated_by'] = $user_id;
            $product_array['created_at'] = $dateTime;
            $product_array['updated_at'] = $dateTime;

            $row_no = $key + 1;
            $category_id = 3; // for hospital inventory category

            try {
                DB::beginTransaction();
                if (empty($value[0])) {
                    $is_valid = false;
                    $error_msg = 'Item/Product name not found.' . $row_no;
                    break;
                }else{
                    $product_array['name'] = trim($value[0]);
                }


                //Add SKU
                $sku = trim($value[1]);
                if (!empty($sku)) {
                    $product_array['sku'] = $sku;
                    //Check if product with same SKU already exist
                    $is_exist = Item::where('sku', $product_array['sku'])->exists();
                    if ($is_exist) {
                        $is_valid = false;
                        $error_msg = "$sku SKU already exist in row no :. $row_no";
                        break;
                    }
                    $product_array['sku'] = $sku;

                }

                if(isset($value[2])){
                    $type = Type::updateOrCreate(['name' =>trim($value[2])]);
                    $product_array['type_id'] = $type->id;
                }

                if(isset($value[3])){
                    $brand = Brand::updateOrCreate(['name' => trim($value[3])]);
                    $product_array['brand_id'] = $brand->id;
                }

                if(isset($value[4])){
                    $strength = Strength::updateOrCreate(['name' => trim($value[4])]);
                    $product_array['strength_id'] = $strength->id;
                }

                $unit_name = trim($value[5]);
                if (empty($unit_name)) {
                    $is_valid = false;
                    $error_msg = 'Item Unit name not found' . $row_no;
                    break;
                }else{
                    $unit_id = Unit::updateOrCreate(['name' => $value[5]])->id;
                    $product_array['unit_id'] = $unit_id;
                }

                $product_array['product_type'] = 'single';
                $product_array['category_id'] = $category_id;

                if(isset($value[6]) && !empty($value[6])){
                    $subcategory =Subcategory::updateOrCreate(['category_id' => $category_id, 'name' =>trim($value[6])]);
                    $product_array['subcategory_id'] = $subcategory->id;
                }

                if(!empty($value[7]) && !empty($value[6]) ){
                    $is_valid = false;
                    $error_msg = 'Item Cateory name not found in row no :' . $row_no;
                    break;
                }
                if(isset($value[7]) && !empty($value[7])){
                    $childCategory =ChildCategory::updateOrCreate(['category_id' => $category_id, 'subcategory_id' => $product_array['subcategory_id'], 'name' =>trim($value[7])]);
                    $product_array['childcategory_id'] = $childCategory->id;
                }

                if(isset($value[8]) && !empty($value[8])){
                    $rack =Rack::updateOrCreate(['name' => trim($value[8])]);
                    $product_array['rack_id'] = $rack->id;
                }
                if(!empty($value[9]) && empty($value[8]) ){
                    $is_valid = false;
                    $error_msg = 'Item Shelf Rack name not found in row no :' . $row_no;
                    break;
                }
                if(isset($value[9]) && !empty($value[9])){
                    $row = Row::updateOrCreate(['rack_id' => $product_array['rack_id'], 'name' => trim($value[9])]);
                    $product_array['row_id'] = $row->id;
                }

                if (isset($value[11]) && !empty($value[11])) {
                    $product_array['alert_quantity']  = Str::replace(',', '', trim($value[11]));
                }

                if (!isset($value[12]) && empty($value[12])) {
                    $is_valid = false;
                    $error_msg = 'Item Unit/Purchase Price not found in row no :' . $row_no;
                    break;
                }

                if (!isset($value[13]) && empty($value[13])) {
                    $is_valid = false;
                    $error_msg = 'Item Sell Price not found in row no :' . $row_no;
                    break;
                }
                if (isset($value[14]) && !empty($value[14])) {
                    $product_array['description']  = trim($value[14]);
                }
                if (isset($value[15]) && !empty($value[15])) {
                    $generic_id = GenericName::updateOrCreate(['name' => trim($value[15])])->id;
                    $product_array['generic_id'] = $generic_id;
                }


                if (!$is_valid) {
                    throw new \Exception($error_msg);
                }

                $profit = 0;
                $profitPercentage = 0;
                // $purchasePrice =  Str::replace(',', '', $value[13]);
                $purchasePrice =  Str::replace(',', '', trim($value[12]));
                $product_array['up_before_tax'] = $purchasePrice;
                $product_array['tax_rate']      = 0;
                $product_array['up_after_tax']  = $purchasePrice;

                $sellPrice =  Str::replace(',', '', $value[14]);
                $product_array['sell_price']  = $sellPrice;

                $profit = $sellPrice - $purchasePrice;
                if ($profit > 0) {
                    $profitPercentage = ($profit / $purchasePrice) * 100;
                }
                $product_array['profit_percent']  = $profitPercentage;
                dd($product_array);
                $item = Item::create($product_array);

                // $item = Item::create([
                    // 'name'              => $value[0],
                    // 'sku'               => $value[1] ?? null,
                    // 'unit_id'           => Unit::updateOrCreate(['name' => $value[5]])->id,
                    // 'product_type'      => 'single',
                    // 'type_id'           => isset($value[2]) ? Type::updateOrCreate(['name' => $value[2]])->id : null ,
                    // 'strength_id'       => isset($value[4]) ? Strength::updateOrCreate(['name' => $value[4]])->id : null,
                    // 'category_id'       => 3,
                    // 'subcategory_id'    => isset($value[7]) ?  Subcategory::updateOrCreate(['category_id' => 3, 'name' => $value[7]])->id : null,
                    // 'childcategory_id'    => isset($value[8]) ?  ChildCategory::updateOrCreate(['category_id' => 3, 'name' => $value[7]])->id : null,
                    // 'up_before_tax'     => $purchasePrice,
                    // 'tax_rate'          => 0,
                    // 'up_after_tax'      => $purchasePrice,
                    // 'profit_percent'    => $profitPercentage,
                    // 'sell_price'        => $sellPrice,
                    // 'description'       => $value[15],
                    // 'alert_quantity'    => 10,
                    // 'created_at'        => date("Y-m-d H:i:s"),
                    // 'updated_at'        => date("Y-m-d H:i:s"),
                    // 'created_by'        => auth('admin')->id()
                // ]);
                $previousQty =  Str::replace(',', '', trim($value[10]));
                if (isset($value[10]) &&  $previousQty > 0) {
                    // $previousQty =  Str::replace(',', '', trim($value[10]));

                    InventoryItem::create([
                        'warehouses_id' => WareHouse::first()->id,
                        'item_id'       => $item->id,
                        'date'          => date('Y-m-d'),
                        'previous_qty'  => $previousQty,
                    ]);

                    ItemCount::updateOrCreate([
                        'item_id' => $item->id
                    ], [
                        'in_qty'  => $previousQty
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
                                'purchase_qty' => DB::raw('purchase_qty + ' . $previousQty),
                                'purchase_unit_price' => $item->up_after_tax
                            ]);
                    } else {
                        // If no record exists with the same item_id and date, insert a new record
                        DB::table('day_wise_stock')->insert([
                            'previous_qty' => $previousQty,
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

