<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\BuildingInformation;
use App\Models\Backend\Complain;
use App\Models\Backend\EmployeeSalary;
use App\Models\Backend\Floor;
use App\Models\Backend\Fund;
use App\Models\Backend\MaintenanceCost;
use App\Models\Backend\MonthConfiguration;
use App\Models\Backend\RentCollection;
use App\Models\Backend\Tenant;
use App\Models\Backend\Unit;
use App\Models\Backend\Visitor;
use App\Models\Backend\Year;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    function expenseReport(Request $request)
    {

        if ($request->start_date && $request->end_date) {

            $startDate       = date('Y-m-d', strtotime($request->start_date));
            $endDate         = date('Y-m-d', strtotime($request->end_date));
            $employeeSalary  = EmployeeSalary::where('branch_id', session('branch_id'))
                ->whereBetween('issue_date', [ $startDate, $endDate ])
                ->get()->sum('amount') ?? 0;
            $maintenanceCost = MaintenanceCost::where('branch_id', session('branch_id'))
                ->whereBetween('date', [ $startDate, $endDate ])
                ->orderBy('id', 'desc')->get()->sum('amount') ?? 0;
            $funds           = Fund::where('branch_id', session('branch_id'))
                ->whereBetween('date', [ $startDate, $endDate ])
                ->with('owner:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            $branch          = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.report.expenseReportPdf', compact('branch', 'maintenanceCost', 'employeeSalary'));

        }
        return view('backend.report.expenseReport');
    }
    function incomeReport(Request $request)
    {

        if ($request->start_date && $request->end_date) {

            $startDate       = date('Y-m-d', strtotime($request->start_date));
            $endDate         = date('Y-m-d', strtotime($request->end_date));
            $employeeSalary  = EmployeeSalary::where('branch_id', session('branch_id'))
                ->whereBetween('issue_date', [ $startDate, $endDate ])
                ->get()->sum('amount') ?? 0;
            $maintenanceCost = MaintenanceCost::where('branch_id', session('branch_id'))
                ->whereBetween('date', [ $startDate, $endDate ])
                ->orderBy('id', 'desc')->get()->sum('amount') ?? 0;
            $rentCollection  = RentCollection::where('branch_id', session('branch_id'))
                ->whereBetween('issue_date', [ $startDate, $endDate ])->get()->sum('total_rent');

            $branch = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.report.incomeReportPdf', compact('branch', 'maintenanceCost', 'rentCollection', 'employeeSalary'));

        }
        return view('backend.report.incomeReport');
    }
    function rentReport(Request $request)
    {

        if ($request->start_date && $request->end_date) {
            $tenant          = Tenant::where('email', auth('admin')->user()->email)->where('mobile', auth('admin')->user()->mobile)->first();
            $rentCollections = RentCollection::where('branch_id', session('branch_id'))
                ->where('tenant_id', $tenant->id)
                ->where('bill_status', $request->payment_status)
                ->with('floor:id,name')
                ->with('unit:id,name')
                ->with('month:id,name')
                ->with('year:id,name')

                ->get();
            $branch          = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.report.rentReportPdf', compact('rentCollections', 'branch'));
        }
        if ($request->floor_id && $request->unit_id && $request->month && $request->year) {
            $rentCollections = RentCollection::where('branch_id', session('branch_id'))
                ->where('floor_id', $request->floor_id)
                ->where('unit_id', $request->unit_id)
                ->where('month_id', $request->month)
                ->where('year_id', $request->year)
                ->where('bill_status', $request->payment_status)
                ->with('floor:id,name')
                ->with('unit:id,name')
                ->with('month:id,name')
                ->with('year:id,name')
                ->get();
            $branch          = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.report.rentReportPdf', compact('rentCollections', 'branch'));
        }
        $months = MonthConfiguration::all();
        $years  = Year::all();
        $floors = Floor::all();
        return view('backend.report.rentReport', compact('months', 'years', 'floors'));
    }
    function tenantReport(Request $request)
    {
        if ($request->tenant_status) {
            $data   = Tenant::where('branch_id', session('branch_id'))
                ->with('unit:id,name', 'floor:id,name')->get();
            $branch = BuildingInformation::where('id', session('branch_id'))->first();

            return view('backend.report.tenantReportPdf', compact('data', 'branch'));
        }


        return view('backend.report.tenantReport');
    }
    function billReport()
    {
        return view('backend.report.billReport');
    }
    function visitorReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate   = date('Y-m-d', strtotime($request->end_date));
            $visitors  = Visitor::where('branch_id', session('branch_id'))
                ->with('floor:id,name', 'unit:id,name')
                ->whereBetween('date', [ $startDate, $endDate ])
                ->get();
            $branch    = BuildingInformation::where('id', session('branch_id'))->first();

            return view('backend.report.visitorReportPdf', compact('visitors', 'branch'));
        }
        return view('backend.report.visitorReport');
    }
    function complainReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate   = date('Y-m-d', strtotime($request->end_date));
            $complains = Complain::where('branch_id', session('branch_id'))

                ->whereBetween('date', [ $startDate, $endDate ])
                ->get();
            $branch    = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.report.complainReportPdf', compact('complains', 'branch'));
        }
        return view('backend.report.complainReport');
    }
    function unitReport(Request $request)
    {
        if ($request->status) {
            $status = $request->status == 1 ? 0 : 1;
            $data   = Unit::with('branch:id,name')
                ->with('floor:id,name')
                ->where('status', $status)
                ->where('branch_id', session('branch_id'))
                ->orderBy('id', 'DESC')
                ->get();
            $branch = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.report.unitStatusReportPdf', compact('data', 'branch'));
        }

        return view('backend.report.unitStatusReport');
    }
    function fundReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate        = date('Y-m-d', strtotime($request->start_date));
            $endDate          = date('Y-m-d', strtotime($request->end_date));
            $funds            = Fund::where('branch_id', session('branch_id'))
                ->whereBetween('date', [ $startDate, $endDate ])
                ->with('owner:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            $maintenanceCosts = MaintenanceCost::where('branch_id', session('branch_id'))
                ->whereBetween('date', [ $startDate, $endDate ])
                ->with('month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            $branch           = BuildingInformation::where('id', session('branch_id'))->first();
            $branch = BuildingInformation::where('id', session('branch_id'))->first();
            return view('backend.fund.owner', compact('funds', 'maintenanceCosts', 'branch'));
        }

        return view('backend.report.fundReport');
    }
    function salaryReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate   = date('Y-m-d', strtotime($request->end_date));
            $data      = EmployeeSalary::where('branch_id', session('branch_id'))
                ->whereBetween('issue_date', [ $startDate, $endDate ])
                ->with('employee:id,name', 'year:id,name', 'month:id,name')
                ->get();
            $branch    = BuildingInformation::where('id', session('branch_id'))->first();

            return view('backend.report.salaryReportPdf', compact('data', 'branch'));
        }


        return view('backend.report.salaryReport');
    }
}
