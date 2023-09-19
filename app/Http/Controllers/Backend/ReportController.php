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
    function rentReport(Request $request)
    {

        if ($request->start_date && $request->end_date) {
             $tenant = Tenant::where('email', auth('admin')->user()->email)->where('mobile', auth('admin')->user()->mobile)->first();
            $rentCollections = RentCollection::where('branch_id', session('branch_id'))
                ->where('tenant_id', $tenant->id)
                ->where('bill_status', $request->payment_status)
                ->with('floor:id,name')
                ->with('unit:id,name')
                ->with('month:id,name')
                ->with('year:id,name')

                ->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();
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
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();
            return view('backend.report.rentReportPdf', compact('rentCollections', 'branch'));
        }
        $months  = MonthConfiguration::all();
        $years  = Year::all();
        $floors = Floor::all();
        return view('backend.report.rentReport', compact('months', 'years', 'floors'));
    }
    function tenantReport(Request $request)
    {
        if ($request->tenant_status) {
            $data = Tenant::where('branch_id', session('branch_id'))
                ->with('unit:id,name', 'floor:id,name')->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();

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
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $visitors = Visitor::where('branch_id', session('branch_id'))
                ->with('floor:id,name', 'unit:id,name')
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();

            return view('backend.report.visitorReportPdf', compact('visitors', 'branch'));
        }
        return view('backend.report.visitorReport');
    }
    function complainReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $complains = Complain::where('branch_id', session('branch_id'))

                ->whereBetween('date', [$startDate, $endDate])
                ->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();
            return view('backend.report.visitorReportPdf', compact('complains', 'branch'));
        }
        return view('backend.report.complainReport');
    }
    function unitReport(Request $request)
    {
        if ($request->status) {
            $status = $request->status == 1 ? 0 : 1;
            $data = Unit::with('branch:id,name')
                ->with('floor:id,name')
                ->where('status', $status)
                ->where('branch_id', session('branch_id'))
                ->orderBy('id', 'DESC')
                ->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();
            return view('backend.report.unitStatusReportPdf', compact('data', 'branch'));
        }

        return view('backend.report.unitStatusReport');
    }
    function fundReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $funds = Fund::where('branch_id', session('branch_id'))
                ->whereBetween('date', [$startDate, $endDate])
                ->with('owner:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            $maintenanceCosts = MaintenanceCost::where('branch_id', session('branch_id'))
                ->whereBetween('date', [$startDate, $endDate])
                ->with('month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();

            return view('backend.fund.owner', compact('funds', 'maintenanceCosts'));
        }

        return view('backend.report.billReport');
    }
    function salaryReport(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $data = EmployeeSalary::where('branch_id', session('branch_id'))
                ->whereBetween('issue_date', [$startDate, $endDate])
                ->with('employee:id,name', 'year:id,name', 'month:id,name')
                ->get();
            $branch = BuildingInformation::where('branch_id', session('branch_id'))->first();

            return view('backend.report.salaryReportPdf', compact('data', 'branch'));
        }


        return view('backend.report.salaryReport');
    }
}
