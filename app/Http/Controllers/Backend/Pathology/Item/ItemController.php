<?php

namespace App\Http\Controllers\Backend\Pathology\Item;

use App\Helpers\Image;
use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Item\Item;
use App\Models\TaxSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Item\Home\StoreRequest;
use App\Http\Requests\Item\Home\UpdateRequest;
use App\Models\Inventory\WareHouse;
use App\Models\Item\Unit;
use App\Models\lab\LabTest;
use App\Models\lab\LabTestInventoryItem;
use App\Models\lab\LabTestItemCount;
use App\Models\lab\LabTestTube;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->optionData) {
            return response()->json(['data' => LabTestTube::whereLike($request->optionData)
                ->select(['id', 'name', 'type_id', 'generic_id', 'strength_id'])
                ->with('genericName:id,name')
                ->with('strength:id,name')
                ->with('type:id,name')
                ->orwhereHas('genericName', function ($q) use ($request) {
                    $q->where('name', 'like',  '%' . $request->optionData . '%')->select(['id', 'name']);
                })
                ->orwhereHas('strength', function ($q) use ($request) {
                    $q->where('name', 'like',  '%' . $request->optionData  . '%')->select(['id', 'name']);
                })
                ->orwhereHas('type', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->optionData  . '%')->select(['id', 'name']);
                })

                ->take(15)->get()]);
        }
        $data = LabTestTube::select(['id', 'name', 'unit_id', 'brand_id', 'status', 'sell_price'])

            ->when($request->unit_id, function ($query) use ($request) {
                $query->where('unit_id', $request->unit_id);
            })
            ->when($request->brand_id, function ($query) use ($request) {
                $query->where('brand_id', $request->brand_id);
            })
            // ->take(10)
            // ->make(true);
            ->get();


        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '<div class="dropdown">
                        <button class="btn btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                        <div class="dropdown-menu"><a href="' . route('backend.pathology.itemConfig.item.edit', $row) . '" class="dropdown-item">
                            <i class="fa fa-edit mr-2" aria-hidden="true"></i> Edit
                        </a><div class="dropdown-divider"></div>
                        <a data-href="' . route('backend.pathology.itemConfig.item.destroy', $row) . '" class="dropdown-item delete_check" data-toggle="tooltip" data-original-title="Delete" aria-describedby="tooltip64483">
                            <i class="fa fa-trash mr-2" aria-hidden="true"></i> Delete
                        </a>
                    </div></div>';
                    return $action;
                })
                ->editColumn('status', function ($row) {
                    return view('components.backend.forms.input.input-switch', ['status' => $row->status]);
                })

                ->editColumn('unit_id', function ($row) {
                    return optional($row->unit)->name;
                })
                ->editColumn('brand_id', function ($row) {
                    return optional($row->brand)->name;
                })
                ->editColumn('sell_price', function ($row) {
                    return number_format($row->sell_price, 2);
                })

                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
            // ->toJson();

        }
        return View::make('backend.pathology.item.home.index');
    }

    public function itemCount(Request $request)
    {
        dd($request->all());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $taxs = TaxSetting::active()->get()->map(function ($tax, $key) {
            return [
                'id' => $tax->id,
                'name' => $tax->name . '(' . $tax->rate . '/' . $tax->type . ')',
            ];
        });
        $appilcationTax = [
            ['name' => 'Included Tax (With Tax)', 'id' => 'included_tax'],
            ['name' => 'Excluded Tax (Without Tax)', 'id' => 'excluded_tax']
        ];
        $product_types = [['name' => 'Single', 'id' => 'single']];

        return View::make('backend.pathology.item.home.create')->with([
            'countries' =>  Country::get(['name', 'id']),
            'appilcationTax' => $appilcationTax,
            'product_types' => $product_types,
            'taxs' => $taxs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $returnData = $this->storeData($request);
        if ($returnData->getData()->status) {
            return back()->with(['success' => $returnData->getData()->msg]);
        }
        return back()->with(['error' => $returnData->getData()->msg]);
    }

    function storeData($request)
    {
        // DD($request->all());
        $validated = $request->validate([
            'name' => [
                'required', 'string',
                Rule::unique('items')
                    ->where(function ($query)  use ($request) {
                        return $query
                            ->where('name', $request->name)
                            ->where('brand_id', $request->manufacture_id)
                            ->where('unit_id', $request->unit_id)
                            ->where('origin_id', $request->origin_id)
                            ->where('strength_id', $request->strength_id)
                            ->where('type_id', $request->type_id);
                    })
            ],
            'sku' => 'nullable|string',
            'product_type' => 'required|string',
            'weight' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'exc_tax' => 'required|string',
            'inc_tax' => 'required|string',
            'tax_rate' => 'required|string',
            'profit_percent' => 'required|string',
            'sell_price' => 'required|string',
            'alert_quantity' => 'nullable|string',
            'unit_id' => 'nullable|string|exists:units,id',
            'type_id' => 'nullable|string|exists:item_types,id',
            'manufacture_id' => 'nullable|string|exists:brands,id',
            'generic_id' => 'nullable|string|exists:generic_names,id',

            'origin_id' => 'nullable|string|exists:countries,id',
            'rack_id' => 'nullable|string|exists:racks,id',
            'row_id' => 'nullable|string|exists:rows,id',
            'tax_id' => 'nullable|string|exists:tax_settings,id',
            'tax_type' => 'required|string'
        ]);
        // DD($request->all());
        try {
            DB::beginTransaction();

            $data = $validated;
            // dd($data);

            $data['description'] = $request->description;
            $data['up_before_tax'] = $request->exc_tax;
            $data['tax_rate'] = $request->tax_rate;
            $data['up_after_tax'] = $request->inc_tax;
            $data['profit_percent'] = $request->profit_percent;
            $data['tax_type'] = $request->tax_type;

            $item = LabTestTube::create($data);
            // dd($item);
            if ($request->previous_qty) {
                LabTestInventoryItem::create([
                    'warehouses_id' => WareHouse::first()->id,
                    'item_id' => $item->id,
                    'date' => date('Y-m-d'),
                    'previous_qty' => $request->previous_qty,
                ]);
                LabTestItemCount::updateOrCreate([
                    'item_id' => $item->id
                ], [
                    'in_qty' => $request->previous_qty
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::whereId($id)->first();
        $taxs = TaxSetting::active()->get()->map(function ($tax, $key) {
            return [
                'id' => $tax->id,
                'name' => $tax->name . '(' . $tax->rate . '/' . $tax->type . ')',
            ];
        });
        $appilcationTax = [
            // ['name'=>'None', 'id' => null],
            ['name' => 'Included Tax (With Tax)', 'id' => 'included_tax'],
            ['name' => 'Excluded Tax (Without Tax)', 'id' => 'excluded_tax']
        ];
        // $product_types = [['name' => 'Single', 'id' => 'single']];
        // $subcategories = Subcategory::where('category_id', $item->category_id)->get();
        // $childcategories = childCategory::where('subcategory_id', $item->subcategory_id)->get();
        return View::make('backend.pathology.item.home.edit', compact('item'))
            ->with([
                // 'subcategories' => $subcategories,
                // 'childcategories' => $childcategories,
                'countries' =>  Country::get(['name', 'id']),
                'appilcationTax' => $appilcationTax,
                'product_types' => $product_types,
                'taxs' => $taxs,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Item $item)
    {
        $returnData = $request->updateData();
        if ($returnData->getData()->status) {
            return back()->with(['success' => $returnData->getData()->msg]);
        }
        return back()->with(['error' => $returnData->getData()->msg]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Item::whereId($id)->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => $ex->getMessage()]);
        }
        (new LogActivity)::addToLog('Item Deleted');
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }


    public function itemInfo(Request $request)
    {
        $item = LabTestTube::whereId($request->item_id)->active()->with('unit')->first();
        // $units = Unit::active()->select('id', 'name')->get();
        $taxs = TaxSetting::active()->select('id', 'name', 'type', 'rate')->get();
        return view('backend.pathology.item.home.itemInfo', compact('item',  'taxs'));
    }

    public function itemPosInfo(Request $request)
    {
        $item   = Item::whereCategoryId()->whereId($request->item_id)->active()->first();
        $units  = Unit::active()->select('id', 'name')->get();
        $taxs   = TaxSetting::active()->select('id', 'name', 'type', 'rate')->get();
        return view('backend.pathology.item.home.itemPosInfo', compact('item', 'units', 'taxs'));
    }
}
