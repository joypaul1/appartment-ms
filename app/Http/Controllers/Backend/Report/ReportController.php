<?php

namespace App\Http\Controllers\Backend\Report;

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

    function appointmentDocWiseReport(Request $request)
    {

        $netIncome = Doctor::select('id', 'first_name', 'last_name', 'email', 'mobile');
        if ($request->doctor_id) {
            $doctor = $netIncome->where('id', $request->doctor_id);
        }
        $netIncome = $netIncome->has('appointment')->with(['appointment' => function ($appointment) use ($request) {
            $appointment->select('id', 'visitType', 'invoice_number', 'payment_status', 'date', 'patient_id', 'doctor_id', 'visitType', 'total_amount')
                ->where('payment_status', 'paid')->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
                ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->with('patient:id,name,mobile,patientId');
        }]);
        $netIncome = $netIncome->get();
        $doctors = Doctor::select('id', 'first_name', 'last_name')->get()->map(function ($query) {
            return [
                'id' => $query->id,
                'name' => $query->first_name . ' ' . $query->last_name
            ];
        });
        return view('backend.report.appointmentDocWiseReport', compact('netIncome', 'doctors'));
    }

    function appointmentReport(Request $request)
    {

        $netIncome = Appointment::query()->with('patient:id,name,mobile,patientId')->with('doctor:id,first_name,last_name')
            ->where('payment_status', 'paid');
        if ($request->appointment_status) {
            $netIncome = $netIncome->where('appointment_status', $request->appointment_status);
        }
        if ($request->doctor_id) {
            $netIncome = $netIncome->where('doctor_id', $request->doctor_id);
        }
        $netIncome = $netIncome->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get();
        // ->sum('total_amount');
        $appointment_status = [['id' => null, 'name' => 'All'], ['id' => 'physical', 'name' => 'Physical'], ['id' => 'online', 'name' => 'Online']];
        // $payment_status = [['id' => null,'name' => 'All'], ['id'=> 'paid', 'name' => 'Paid'],[ 'id'=>'due', 'name' => 'due'] ];
        $doctors = Doctor::select('id', 'first_name', 'last_name')->get()->map(function ($query) {
            return [
                'id' => $query->id,
                'name' => $query->first_name . ' ' . $query->last_name
            ];
        });
        return view('backend.report.appointmentReport', compact('netIncome', 'doctors', 'appointment_status'));
    }
    function radiologyReport(Request $request)
    {
        $netIncome =  RadiologyServiceInvoice::query()->with('patient:id,name,mobile,patientId')
            ->with('doctor:id,first_name,last_name');
        if ($request->payment_status) {
            $netIncome = $netIncome->where('payment_status', $request->payment_status);
        }

        if ($request->reference_id) {
            $netIncome = $netIncome->where('reference_id', $request->reference_id);
        }
        $netIncome = $netIncome->with('reference:id,name')
            ->withCount('itemDetails')
            ->with('itemDetails:id,service_invoice_id,service_name_id', 'itemDetails.serviceName:id,name')

            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get();
        $payment_status = [['id' => null, 'name' => 'All'], ['id' => 'paid', 'name' => 'Paid'], ['id' => 'due', 'name' => 'due']];

        return view('backend.report.radiologyReport', compact('netIncome',  'payment_status'));
    }
    function pathologyReport(Request $request)
    {
        $netIncome =  LabInvoice::query()->with('patient:id,name,mobile,patientId')
            ->with('doctor:id,first_name,last_name');
        if ($request->payment_status) {
            $netIncome = $netIncome->where('payment_status', $request->payment_status);
        }

        if ($request->reference_id) {
            $netIncome = $netIncome->where('reference_id', $request->reference_id);
        }
        $netIncome = $netIncome->with('reference:id,name')
            ->withCount('labTestDetails')
            ->with('labTestDetails:id,lab_invoice_id,lab_test_id', 'labTestDetails.testName:id,name')

            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get();
        $payment_status = [['id' => null, 'name' => 'All'], ['id' => 'paid', 'name' => 'Paid'], ['id' => 'due', 'name' => 'due']];

        return view('backend.report.pathologyReport', compact('netIncome',  'payment_status'));
    }
    function dialysisReport(Request $request)
    {
        $patientsWithAppointments = Patient::withCount('dialysisAppointment')
            ->whereHas('dialysisAppointment', function ($query) use ($request) {
                $query->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
                    ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))));
            })->with('dialysisAppointment:id,patient_id,date,appointment_status,payment_status,doctor_id,invoice_number,total_amount')
            ->get();


        return view('backend.report.dialysisReport', compact('patientsWithAppointments'));
    }



    public function incomeReport(Request $request)
    {
        $appointment = Appointment::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->sum('paid_amount');
        $dialysisAppointment = DialysisAppointment::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->sum('paid_amount');


        $labInvoice = LabInvoice::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->sum('total_amount');

        $serviceInvoice = ServiceInvoice::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get()->sum('paid_amount');

        $orderInvoice =  Order::whereHas('orderStatus', function ($query) {
            $query->whereStatus('paid');
        })
            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->latest()->get()->sum('total');

        if ($request->start_date && $request->end_date) {
            return view('backend.report.incomePrint', compact('appointment',  'dialysisAppointment', 'serviceInvoice', 'labInvoice', 'orderInvoice'));
        }

        return view('backend.report.incomereport');
    }
    public function expenseReport(Request $request)
    {

        $doctorWithDrawHistory = DoctorWithDrawHistory::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get()->sum('amount');
        // $expenses = Expense::with('typeOfExpense:id,name')->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
        //     ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get();
        // ->sum('amount');

        $othersExpense = AccountHead::whereName('Expenses')->with(['groups.ledgers.expense' => function ($transaction) use ($request) {
            $transaction->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
                ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))));
        }])->get();
        if ($request->start_date && $request->end_date) {
            return view('backend.report.expensePrint', compact('othersExpense', 'doctorWithDrawHistory'));
        }
        return view('backend.report.expense');
    }

    public function profitReport(Request $request)
    {
        //all income
        $appointment = Appointment::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->get();

        $labInvoice = LabInvoice::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->get();

        $dialysisAppointment = DialysisAppointment::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->get();
        $serviceInvoice = ServiceInvoice::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get();

        $orderInvoice = Order::whereHas('orderStatus', function ($query) {
            $query->whereStatus('paid');
        })
            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->latest()->get();

        //all income
        // all expense
        $doctorWithDrawHistory = DoctorWithDrawHistory::whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))->get()->sum('amount');
        $othersExpense = AccountHead::whereName('Expenses')->with(['groups.ledgers.expense' => function ($transaction) use ($request) {
            $transaction->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
                ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))));
        }])->get();
        // end all expense
        if ($request->start_date && $request->end_date) {
            return view('backend.report.profitPrint', compact('othersExpense', 'doctorWithDrawHistory', 'appointment',  'dialysisAppointment', 'serviceInvoice', 'labInvoice', 'orderInvoice'));
        }
        return view('backend.report.profitReport');
    }

    public function dayBook(Request $request)
    {
        $daybooks = DailyAccountTransaction::with('transactionHistories')
            ->get();

        return view('backend.report.daybook', compact('daybooks'));
    }
    public function cashFlow(Request $request)
    {
        $cashFlows = CashFlow::with('ledger:id,name')
            ->with('method:id,name')
            ->with('cashflowHistory')
            ->get();
        // $model = new $media->cashflowable_type;
        // return  $media->model = $model->findOrFail($media->cashflowable_id);
        return view('backend.report.cashflow', compact('cashFlows'));
    }

    public function dayWiseStock(Request $request)
    {

        // Assuming the start_date and end_date for filtering
        $start_date = date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d')));
        $end_date = date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d')));
        // up_after_tax
        // return  $result = DB::select("
        //     SELECT
        //         i.id AS item_id,
        //         i.name AS item_name,
        //         i.up_after_tax as purchase_price,
        //         SUM(ii.pur_qty) AS purchase_qty,
        //         SUM(ii.pur_qty * i.up_after_tax) AS total_purchase_price,
        //         SUM(ii.sell_qty) AS sell_qty,
        //         SUM(ii.sell_qty * i.sell_price) AS total_sell_price,
        //         SUM(ii.available_qty) AS stock_available_qty,
        //         COALESCE(prev_stock.available_qty, 0) AS previous_stock,
        //         i.sell_price,
        //     FROM
        //         items i
        //     LEFT JOIN
        //         inventory_items ii ON i.id = ii.item_id AND ii.date BETWEEN ? AND ?
        //     LEFT JOIN
        //    (
        //        SELECT
        //            item_id,
        //            SUM(available_qty) AS available_qty
        //        FROM
        //            inventory_items
        //        WHERE
        //            date < ?
        //        GROUP BY
        //            item_id
        //         ) prev_stock ON i.id = prev_stock.item_id
        //     GROUP BY
        //         i.id, i.name, prev_stock.available_qty", [$start_date, $end_date, $start_date]);
          $data  = DB::table('items as item_table')
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


        return view('backend.report.dayWiseStock', compact('data'));
    }
    public function sellReport(Request $request)
    {
        $data = Order::whereHas('orderStatus', function ($query) {
            $query->whereStatus('paid');
        })
            ->whereDate('date', '>=', date('Y-m-d', strtotime($request->start_date ?? date('Y-m-d'))))
            ->whereDate('date', '<=', date('Y-m-d', strtotime($request->end_date ?? date('Y-m-d'))))
            ->latest()->get();

        return view('backend.report.sellReport', compact('data'));
    }

    function stockReport(Request $request)
    {
        $data = InventoryItem::latest();
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

        return view('backend.report.stockReport')
            ->with(['warehouses' =>  WareHouse::get(['name', 'id'])]);
    }
    function stockSummary(Request $request)
    {



        if ($request->ajax()) {
            $data = ItemCount::select('id', 'item_id', 'in_qty', 'out_qty', 'available_qty')
                ->with(
                    'item:id,name,category_id,generic_id,up_after_tax,sell_price',
                    'item.category:id,name',
                    'item.genericName:id,name'
                )->latest()
                ->when($request->item_id, function ($query) use ($request) {
                    $query->where('item_id', $request->item_id);
                })
                ->when($request->category_id, function ($query) use ($request) {
                    $query->whereHas('item.category', function ($query) use ($request) {
                        $query->where('category_id', $request->category_id);
                    });
                })
                ->when($request->generic_id, function ($query) use ($request) {
                    $query->whereHas('item.genericName', function ($query) use ($request) {
                        $query->where('generic_id', $request->generic_id);
                    });
                })->take(5)->get();
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

        return view('backend.report.stockSummary')
            ->with(['items' =>  Item::select('id', 'name')->get()])
            ->with(['genericNames' =>  GenericName::select('id', 'name')->get()])
            ->with(['categories' =>  Category::select('id', 'name')->get()]);
    }

    function stockAlert(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('items')
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


        return view('backend.report.stockAlert');
    }
    function expireReport(Request $request)
    {

        if ($request->ajax()) {
            $currentDate = date('Y-m-d');
            $expiredProducts = DB::table('inventory_items')
                ->join('items', 'inventory_items.item_id', '=', 'items.id')
                ->where('expire_date', '<=', $currentDate)
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
        return view('backend.report.expireReport');
    }

    public function purchaseReport(Request $request)
    {
        $data = Purchase::latest()
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
                ->addColumn('action', function ($row) {
                    $action = '<div class="dropdown">
                    <button class="btn btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" ><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                        <div class="dropdown-menu">
                        <a data-href="' . route('backend.purchase.edit', $row) . '" class="dropdown-item edit_check"
                            data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit mr-2" aria-hidden="true"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-href="' . route('backend.purchase.destroy', $row) . '"class="dropdown-item delete_check"  data-toggle="tooltip"
                            data-original-title="Delete" aria-describedby="tooltip64483"><i class="fa fa-trash mr-2" aria-hidden="true"></i> Delete
                        </a>
                    </div></div>';
                    return $action;
                })

                ->editColumn('status', function ($row) {
                    return view('components.backend.forms.input.input-switch', ['status' => $row->status]);
                })
                ->editColumn('invoice_number', function ($row) {
                    return session('invoice_prefix')['purchase'] . '-' . $row->invoice_number;
                })
                ->editColumn('supplier_id', function ($row) {
                    return optional($row->supplier)->name;
                })

                ->editColumn('warehouse_id', function ($row) {
                    return  optional($row->warehouse)->name;
                })
                ->removeColumn(['id'])
                ->rawColumns(['action'])
                ->make(true);
        }

        $status =  (object)[['name' => 'Active', 'id' => 1], ['name' => 'Inactive', 'id' => 0]];
        return view('backend.report.purchaseReport', compact('status'));
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

        return view('backend.report.patientVisit', compact('doctor', 'department', 'history', 'regularVisit', 'reportVisit'));
    }


    public function sellSummaryStore(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $data = Order::whereHas('orderStatus', function ($query) {
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
        return view('backend.report.sellSummary', compact('data', 'start_date', 'end_date'));
    }
}
