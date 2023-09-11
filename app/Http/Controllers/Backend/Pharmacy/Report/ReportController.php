<?php

namespace App\Http\Controllers\Backend\Pharmacy\Report;

use App\Http\Controllers\Controller;
use App\Models\Account\AccountHead;
use App\Models\Appointment\Appointment;
use App\Models\Appointment\DialysisAppointment;
use App\Models\lab\LabInvoice;
use App\Models\Radiology\RadiologyServiceInvoice;

use App\Models\DailyAccountTransaction;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorWithDrawHistory;
use App\Models\Employee\Department;
use App\Models\Expense\Expense;
use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\WareHouse;
use App\Models\Item\Category;
use App\Models\Item\GenericName;
use App\Models\Item\Item;
use App\Models\Item\Subcategory;
use App\Models\ItemCount;
use App\Models\Order;
use App\Models\Patient\Patient;
use App\Models\Purchase\Purchase;
use App\Models\Service\ServiceInvoice;
use App\Models\Transaction\CashFlow;
use App\Models\Transaction\CashFlowHistory;
use App\Models\Transaction\TransactionHistory;
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
        $data  = DB::table('items as item_table')->where('item_table.category_id', 1)
            ->leftJoin('day_wise_stock', function ($join) use ($start_date, $end_date) {
                $join->on('item_table.id', '=', 'day_wise_stock.item_id')
                    ->whereBetween('day_wise_stock.date', [$start_date, $end_date]);
            })
            ->select(
                'day_wise_stock.previous_qty',
                'day_wise_stock.purchase_qty',
                'day_wise_stock.purchase_unit_price',
                'day_wise_stock.pur_sub_total',
                'day_wise_stock.sell_qty',
                'day_wise_stock.sell_unit_price',
                'day_wise_stock.sell_sub_total',
                'day_wise_stock.avaiable_qty',
                'item_table.name as item_name'
            )
            // ->get()
            ->paginate(20);


        return view('backend.pharmacy.report.dayWiseStock', compact('data'));
    }
    public function sellReport(Request $request)
    {
        $data = Order::where('order_type', 'pharmacy')->whereHas('orderStatus', function ($query) {
            $query->whereStatus('paid');
        })
            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->latest()->get();

        return view('backend.pharmacy.report.sellReport', compact('data'));
    }

    function stockReport(Request $request)
    {
        $data = InventoryItem::whereHas('item', function ($item) {
            return $item->where('category_id', 1);
        })->latest();
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

        return view('backend.pharmacy.report.stockReport')
            ->with(['warehouses' =>  WareHouse::get(['name', 'id'])]);
    }
    function stockSummary(Request $request)
    {
        // dd(23434);
        if ($request->ajax()) {
            // dd(34324);
            $data = ItemCount::whereHas('item', function ($item) {
                return $item->where('category_id', 1);
            })->select('id', 'item_id', 'in_qty', 'out_qty', 'available_qty')
                ->with(
                    'item:id,name,category_id,generic_id,up_after_tax,sell_price'
                )->latest()
                ->when($request->item_id, function ($query) use ($request) {
                    $query->where('item_id', $request->item_id);
                })
                ->when($request->subcategory_id, function ($query) use ($request) {
                    $query->where('subcategory_id', $request->subcategory_id);
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

        return view('backend.pharmacy.report.stockSummary')
            ->with(['items' =>  Item::where('category_id', 1)->select('id', 'name')->get()])
            ->with(['genericNames' =>  GenericName::select('id', 'name')->get()])
            ->with(['subcategories' =>  Subcategory::where('category_id', 1)->select('id', 'name')->get()]);
    }

    function stockAlert(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('items')
                ->where('items.category_id', 1)
                ->join('item_counts', 'items.id', '=', 'item_counts.item_id')
                ->where('items.alert_quantity', '>=', DB::raw('item_counts.available_qty'))
                ->select('items.id', 'items.name', 'items.alert_quantity', 'item_counts.available_qty')
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


        return view('backend.pharmacy.report.stockAlert');
    }
    function expireReport(Request $request)
    {

        if ($request->ajax()) {
            $currentDate = date('Y-m-d');
            $expiredProducts = DB::table('inventory_items')
                ->join('items', 'inventory_items.item_id', '=', 'items.id')
                ->where('expire_date', '<=', $currentDate)
                ->where('items.category_id', 1)
                ->select(
                    'items.id',
                    'items.name',
                    'inventory_items.expire_date',
                    'inventory_items.date as purchase_date',
                    'inventory_items.available_qty'
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
        return view('backend.pharmacy.report.expireReport');
    }

    public function purchaseReport(Request $request)
    {
        $data = Purchase::where('purchase_type', 'pharmacy')->latest()
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
        return view('backend.pharmacy.report.purchaseReport', compact('status'));
    }
    public function purchaseDiscountReport(Request $request)
    {
        $data = Purchase::where('purchase_type', 'pharmacy')->where('discount_amount', '>', 0)->latest()
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
        return view('backend.pharmacy.report.purchaseDiscountReport', compact('status'));
    }

    public function patientVisit(Request $request)
    {
        $data2 = [];
        $history = [];
        $regularVisit = 0;
        $reportVisit = 0;
        $doctor = Doctor::get()->map(function ($doctor) {
            $data['id'] = $doctor->id;
            $data['name'] = $doctor->first_name . ' ' . $doctor->last_name;
            $data['department'] = $doctor->department->name;
            return $data;
        });
        if ($request->doctor_id) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $data = Appointment::query()
                ->where('doctor_id', $request->doctor_id)
                ->select('id', 'doctor_id', 'patient_id', 'appointment_date', 'paid_amount', 'visitType')
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->with('patient:id,name,patientId');
            $history        = $data->get();
        }
        $department = Department::get()->map(function ($doctor) {
            $data['id'] = $doctor->id;
            $data['name'] = $doctor->name;
            return $data;
        });

        return view('backend.pharmacy.report.patientVisit', compact('doctor', 'department', 'history', 'regularVisit', 'reportVisit'));
    }


    public function sellSummaryStore(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $data = Order::where('sell_type', 'pharmacy')->whereHas('orderStatus', function ($query) {
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
        return view('backend.pharmacy.report.sellSummary', compact('data', 'start_date', 'end_date'));
    }
}
