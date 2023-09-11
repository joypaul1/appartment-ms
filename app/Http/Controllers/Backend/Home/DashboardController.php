<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Appointment\Appointment;
use App\Models\Appointment\DialysisAppointment;
use App\Models\lab\LabTestReport;
use App\Models\lab\LabInvoice;
use App\Models\Radiology\RadiologyServiceInvoice;
use App\Models\Radiology\RadiologyServiceInvoiceItem;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.dashboard.index');
    }
}
