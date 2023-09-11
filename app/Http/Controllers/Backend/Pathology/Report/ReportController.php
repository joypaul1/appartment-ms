<?php

namespace App\Http\Controllers\Backend\Pathology\Report;

use App\Http\Controllers\Controller;
use App\Models\Inventory\WareHouse;
use App\Models\Item\GenericName;
use App\Models\lab\LabTestInventoryItem;
use App\Models\lab\LabTestItemCount;
use App\Models\lab\LabTestPurchase;
use App\Models\lab\LabTestTube;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function dayWiseStock(Request $request)
    {

        // Assuming the start_date and end_date for filtering
        $start_date = date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d')));
        $end_date = date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d')));
        $data  = DB::table('lab_test_tubes as item_table')
            ->leftJoin('lab_test_day_wise_stock', function ($join) use ($start_date, $end_date) {
                $join->on('item_table.id', '=', 'lab_test_day_wise_stock.item_id')
                    ->whereBetween('lab_test_day_wise_stock.date', [$start_date, $end_date]);
            })
            ->select(
                'lab_test_day_wise_stock.previous_qty',
                'lab_test_day_wise_stock.purchase_qty',
                'lab_test_day_wise_stock.purchase_unit_price',
                'lab_test_day_wise_stock.pur_sub_total',
                'lab_test_day_wise_stock.sell_qty',
                'lab_test_day_wise_stock.sell_unit_price',
                'lab_test_day_wise_stock.sell_sub_total',
                'lab_test_day_wise_stock.avaiable_qty',
                'item_table.name as item_name'
            )
            // ->get()
            ->paginate(20);


        return view('backend.pathology.report.daywiseStock', compact('data'));
    }
    public function sellReport(Request $request)
    {
        $data = Order::where('order_type', 'dialysis')->whereHas('orderStatus', function ($query) {
            $query->whereStatus('paid');
        })
            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->latest()->get();

        return view('backend.pathology.report.sellReport', compact('data'));
    }

    function stockReport(Request $request)
    {
         $data = LabTestInventoryItem::latest();
        $data = $data->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('warehouses_id', function ($row) {
                    return optional($row->warehouse)->name;
                })
                ->editColumn('item_id', function ($row) {
                    return optional($row->item)->name;
                })
                ->editColumn('previous_qty', function ($row) {
                    return number_format($row->previous_qty, 2);
                })
                ->editColumn('pur_qty', function ($row) {
                    return number_format($row->pur_qty, 2);
                })
                ->editColumn('pur_return_qty', function ($row) {
                    return number_format($row->pur_return_qty, 2);
                })
                ->editColumn('sell_qty', function ($row) {
                    return number_format($row->sell_qty, 2);
                })
                ->editColumn('sell_return_qty', function ($row) {
                    return number_format($row->sell_return_qty, 2);
                })
                ->editColumn('sell_replacement_qty', function ($row) {
                    return number_format($row->sell_replacement_qty, 2);
                })
                ->editColumn('damage_qty', function ($row) {
                    return number_format($row->damage_qty, 2);
                })
                ->editColumn('transfer_in', function ($row) {
                    return number_format($row->transfer_in, 2);
                })
                ->editColumn('transfer_out', function ($row) {
                    return number_format($row->transfer_out, 2);
                })
                ->editColumn('available_qty', function ($row) {
                    return number_format($row->available_qty, 2);
                })
                ->removeColumn(['id'])
                ->make(true);
        }

        return view('backend.pathology.report.stockReport')
            ->with(['warehouses' =>  WareHouse::get(['name', 'id'])]);
    }
    function stockSummary(Request $request)
    {
        if ($request->ajax()) {
            $data = LabTestItemCount::select('id', 'item_id', 'in_qty', 'out_qty', 'available_qty')
                ->with(
                    'item:id,name,generic_id,up_after_tax,sell_price'
                    // 'item.category:id,name',
                    // 'item.genericName:id,name'
                )->latest()
                ->when($request->item_id, function ($query) use ($request) {
                    $query->where('item_id', $request->item_id);
                })

                ->when($request->generic_id, function ($query) use ($request) {
                    $query->where('generic_id', $request->generic_id);

                })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('item_id', function ($row) {
                    return optional($row->item)->name;
                })
                ->addColumn('stock_value_by_purchase_price', function ($row) {
                    return number_format($row->item->up_after_tax * $row->available_qty, 2);
                })
                ->addColumn('stock_value_by_sell_price', function ($row) {
                    return number_format($row->item->sell_price * $row->available_qty, 2);
                })

                ->removeColumn(['id'])
                ->rawColumns(['stock_value_by_purchase_price', 'stock_value_by_sell_price'])
                ->make(true);
        }

        return view('backend.pathology.report.stockSummary')
            ->with(['items' =>  LabTestTube::select('id', 'name')->get()])
            ->with(['genericNames' =>  GenericName::select('id', 'name')->get()]);
    }

    function stockAlert(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('lab_test_tubes')
                ->join('lab_test_item_counts', 'lab_test_tubes.id', '=', 'lab_test_item_counts.item_id')
                ->where('lab_test_tubes.alert_quantity', '>=', DB::raw('lab_test_item_counts.available_qty'))
                ->select('lab_test_tubes.id', 'lab_test_tubes.name', 'lab_test_tubes.alert_quantity', 'lab_test_item_counts.available_qty')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('alert_quantity', function ($row) {
                    return number_format($row->alert_quantity, 2);
                })
                ->editColumn('available_qty', function ($row) {
                    return number_format($row->available_qty, 2);
                })
                ->removeColumn(['id'])
                ->make(true);
        }


        return view('backend.pathology.report.stockAlert');
    }
    function expireReport(Request $request)
    {

        if ($request->ajax()) {
            $currentDate = date('Y-m-d');
            $expiredProducts = DB::table('lab_test_inventory_items')
                ->join('lab_test_tubes', 'lab_test_inventory_items.item_id', '=', 'lab_test_tubes.id')
                ->where('expire_date', '<=', $currentDate)

                ->select(
                    'lab_test_tubes.id',
                    'lab_test_tubes.name',
                    'lab_test_inventory_items.expire_date',
                    'lab_test_inventory_items.date as purchase_date',
                    'lab_test_inventory_items.available_qty'
                )
                ->get();
            return DataTables::of($expiredProducts)
                ->addIndexColumn()
                ->editColumn('purchase_date', function ($row) {
                    return date('m-d-Y', strtotime($row->purchase_date));
                })
                ->editColumn('expire_date', function ($row) {
                    return date('m-d-Y', strtotime($row->expire_date));
                })
                ->removeColumn(['id'])
                ->make(true);
        }
        return view('backend.pathology.report.expireReport');
    }

    public function purchaseReport(Request $request)
    {
         $data = LabTestPurchase::latest()
            ->when($request->start_date, function ($query) use ($request) {
                if ($request->start_date === true) {
                    return $query->whereDate('purchase_date', '>=', date('Y-m-d'));
                } else {
                    return $query->whereDate('purchase_date', '>=', date('Y-m-d', strtotime($request->start_date)));
                }
            })
            ->when($request->end_date, function ($query) use ($request) {
                if ($request->end_date === true) {
                    return $query->where('purchase_date', '<=', date('Y-m-d'));
                } else {
                    return $query->whereDate('purchase_date', '<=',  date('Y-m-d', strtotime($request->end_date)));
                }
            });


            $data = $data->get();
            if (request()->ajax()) {
                return DataTables::of($data)
                    ->addIndexColumn()

                    ->editColumn('invoice_number', function ($row) {
                        return session('invoice_prefix')['purchase'] . '-' . $row->invoice_number;
                    })
                    ->editColumn('supplier_id', function ($row) {
                        return optional($row->supplier)->name;
                    })
                    ->editColumn('subtotal_amount', function ($row) {
                        return number_format($row->subtotal_amount, 2);
                    })
                    ->editColumn('discount_amount', function ($row) {
                        return number_format($row->discount_amount, 2);
                    })
                    ->editColumn('total_amount', function ($row) {
                        return number_format($row->total_amount, 2);
                    })
                    ->editColumn('paid_amount', function ($row) {
                        return number_format($row->paid_amount, 2);
                    })
                    ->editColumn('due_amount', function ($row) {
                        return number_format($row->due_amount, 2);
                    })
                    ->editColumn('warehouse_id', function ($row) {
                        return  optional($row->warehouse)->name;
                    })
                    ->editColumn('purchase_date', function ($row) {
                        return  date('d-m-Y', strtotime($row->purchase_date));
                    })
                    ->removeColumn(['id'])
                    ->rawColumns(['action'])
                    ->make(true);
            }

        $status =  (object)[['name' => 'Active', 'id' => 1], ['name' => 'Inactive', 'id' => 0]];
        return view('backend.pathology.report.purchaseReport', compact('status'));
    }

    public function purchaseDiscountReport(Request $request)
    {
        $data = LabTestPurchase::where('discount_amount', '>', 0)->latest()
            ->when($request->start_date, function ($query) use ($request) {
                if ($request->start_date === true) {
                    return $query->whereDate('purchase_date', '>=', date('Y-m-d'));
                } else {
                    return $query->whereDate('purchase_date', '>=', date('Y-m-d', strtotime($request->start_date)));
                }
            })
            ->when($request->end_date, function ($query) use ($request) {
                if ($request->end_date === true) {
                    return $query->where('purchase_date', '<=', date('Y-m-d'));
                } else {
                    return $query->whereDate('purchase_date', '<=',  date('Y-m-d', strtotime($request->end_date)));
                }
            });

        $data = $data->get();
        if (request()->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('invoice_number', function ($row) {
                    return session('invoice_prefix')['purchase'] . '-' . $row->invoice_number;
                })
                ->editColumn('supplier_id', function ($row) {
                    return optional($row->supplier)->name;
                })
                ->editColumn('subtotal_amount', function ($row) {
                    return number_format($row->subtotal_amount, 2);
                })
                ->editColumn('discount', function ($row) {
                    return number_format($row->discount, 2);
                })
                ->editColumn('discount_amount', function ($row) {
                    return number_format($row->discount_amount, 2);
                })
                ->editColumn('total_amount', function ($row) {
                    return number_format($row->total_amount, 2);
                })
                ->editColumn('purchase_date', function ($row) {
                    return  date('d-m-Y', strtotime($row->purchase_date));
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        $status =  (object)[['name' => 'Active', 'id' => 1], ['name' => 'Inactive', 'id' => 0]];
        return view('backend.dialysis.report.purchaseDiscountReport', compact('status'));
    }

    public function sellSummaryStore(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $data = Order::where('sell_type', 'dialysis')->whereHas('orderStatus', function ($query) {
            $query->whereStatus('paid');
        })->selectRaw('sum(total) as total, DATE(date) as date')
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->groupBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date'  => date('d M', strtotime($item->date)),
                    'total' => $item->total,
                ];
            });
        return view('backend.pathology.report.sellSummary', compact('data', 'start_date', 'end_date'));
    }
}
