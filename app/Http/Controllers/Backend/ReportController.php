<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function rentReport()
    {
        return view('backend.report.rentReport');
    }
    function tenantReport()
    {
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
