<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\BuildingInformation;
use App\Models\Backend\Floor;
use App\Models\Backend\MonthConfiguration;
use App\Models\Backend\Rent;
use App\Models\Backend\RentCollection;
use App\Models\Backend\Tenant;
use App\Models\Backend\Year;
use App\Models\Branch;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function rentReport(Request $request)
    {
        if ($request->floor_id && $request->unit_id && $request->month && $request->year) {
            $rentCollections = RentCollection::where('branch_id', 7)->where('floor_id', $request->floor_id)
                ->where('unit_id', $request->unit_id)
                ->where('month_id', $request->month)
                ->where('year_id', $request->year)
                ->where('bill_status', $request->payment_status)
                ->with('floor:id,name')
                ->with('unit:id,name')
                ->with('month:id,name')
                ->with('year:id,name')

                ->get();
            $branch = BuildingInformation::whereId(7)->first();
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
            $data = Tenant::where('branch_id', auth('admin')->user()->branch_id)
                ->with('unit:id,name', 'floor:id,name')->get();
            $branch = BuildingInformation::whereId(7)->first();

            return view('backend.report.tenantReportPdf', compact('data', 'branch'));
        }


        return view('backend.report.tenantReport');
    }
    function billReport()
    {
        return view('backend.report.billReport');
    }
    function visitorReport()
    {
        return view('backend.report.visitorReport');
    }
    function complainReport()
    {
        return view('backend.report.complainReport');
    }
    function unitReport()
    {
        return view('backend.report.unitStatusReport');
    }
    function fundReport()
    {
        return view('backend.report.create');
    }
    function salaryReport()
    {
        return view('backend.report.salaryReport');
    }
}
