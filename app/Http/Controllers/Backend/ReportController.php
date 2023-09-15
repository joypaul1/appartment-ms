<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function rentReport()
    {
        return view('backend.report.create');
    }
    function tenantReport()
    {
        return view('backend.report.create');
    }
    function billReport()
    {
        return view('backend.report.create');
    }
    function visitorReport()
    {
        return view('backend.report.create');
    }
    function complainReport()
    {
        return view('backend.report.create');
    }
    function unitReport()
    {
        return view('backend.report.create');
    }
    function fundReport()
    {
        return view('backend.report.create');
    }
}
