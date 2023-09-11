<?php

namespace App\Http\Requests\Item\Home;

use App\Helpers\Image;
use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\WareHouse;
use App\Models\Item\Item;
use App\Models\ItemCount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
            'name' => [
                'required', 'string',
                Rule::unique('items')
                    ->where(function ($query) {
                        return $query
                            ->where('name', $this->name)
                            ->where('brand_id', $this->manufacture_id)
                            ->where('unit_id', $this->unit_id)
                            ->where('origin_id', $this->origin_id)
                            ->where('category_id', $this->category_id)
                            ->where('subcategory_id', $this->subcategory_id)
                            ->where('childcategory_id', $this->childcategory_id)
                            ->where('strength_id', $this->strength_id)
                            ->where('type_id', $this->type_id);
                    })
            ],
            'sku'               => 'nullable|string',
            'product_type'      => 'required|string',
            'weight'            => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'exc_tax'           => 'required|string',
            'inc_tax'           => 'required|string',
            'tax_rate'          => 'nullable|string',
            'profit_percent'    => 'required|string',
            'sell_price'        => 'required|string',
            'alert_quantity'    => 'nullable|string',
            'unit_id'           => 'nullable|string|exists:units,id',
            'type_id'           => 'nullable|string|exists:item_types,id',
            'brand_id'          => 'nullable|string|exists:brands,id',
            'generic_id'        => 'nullable|string|exists:generic_names,id',
            'category_id'       => 'required|string|exists:categories,id',
            'subcategory_id'    => 'nullable|string|exists:subcategories,id',
            'childcategory_id'  => 'nullable|string|exists:childcategories,id',
            'origin_id'         => 'nullable|string|exists:countries,id',
            'rack_id'           => 'nullable|string|exists:racks,id',
            'row_id'            => 'nullable|string|exists:rows,id',
            'tax_id'            => 'nullable|string|exists:tax_settings,id',
            'tax_type'          => 'nullable|string'

        ];
    }
    public function storeData()
    {

        try {
            DB::beginTransaction();
            $data = $this->validated();
            if ($this->image) {
                $data['image']      = (new Image)->dirName('item/image')->file($this->image)->resizeImage(235, 235)->save();
                $data['b_image']    = (new Image)->dirName('item/b_image')->file($this->image)->resizeImage(550, 500)->save();
            }

            $data['description']    = $this->description;
            $data['up_before_tax']  = Str::replace(',', '', $this->exc_tax);
            $data['tax_rate']       = Str::replace(',', '', $this->tax_rate) ;
            $data['up_after_tax']   = Str::replace(',', '', $this->inc_tax) ;
            $data['profit_percent'] = Str::replace(',', '', $this->profit_percent) ;
            $data['sell_price']     = Str::replace(',', '', $this->sell_price) ;
            $data['tax_type']       = $this->tax_type;

            $item = Item::create($data);

            if ($this->previous_qty) {
                InventoryItem::create([
                    'warehouses_id' => WareHouse::first()->id,
                    'item_id' => $item->id,
                    'date' => date('Y-m-d'),
                    'previous_qty' => $this->previous_qty,
                ]);
                ItemCount::updateOrCreate([
                    'item_id' => $item->id
                ], [
                    'in_qty' => $this->previous_qty
                ]);
            }


            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
            return response()->json(['status' => false, 'msg' => $ex->getLine(), $ex->getMessage()]);
        }
        return response()->json(['status' => true, 'msg' => 'Data Stored Successfully']);
    }
}
