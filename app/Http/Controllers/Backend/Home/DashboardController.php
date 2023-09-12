<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $result_floor = DB::table('floors')
            ->select(DB::raw('count(id) as total_floor'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $result_unit = DB::table('unit_configurations')
            ->select(DB::raw('count(id) as total_unit'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $result_owner = DB::table('owners')
            ->select(DB::raw('count(id) as total_owner'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $total_rent = DB::table('rent_configurations')
            ->select(DB::raw('count(id) as total_rent'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $total_employee = DB::table('employees')
            ->select(DB::raw('count(id) as total_employee'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $total_fair = DB::table('fairs')
            ->select(DB::raw('count(id) as total_fair'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $daily_cost = DB::table('daily_costs')
            ->select(DB::raw('count(id) as daily_cost'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $management_committee = DB::table('management_committees')
            ->select(DB::raw('count(id) as management_committee'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $management_committee = DB::table('funds')
            ->select(DB::raw('count(id) as fund'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->get();
        $result_ou = DB::table('tbl_add_fair')
            ->select(
                DB::raw('sum(water_bill) as w_bil'),
                DB::raw('sum(electric_bill) as e_bil'),
                DB::raw('sum(gas_bill) as g_bil'),
                DB::raw('sum(security_bill) as s_bil'),
                DB::raw('sum(utility_bill) as u_bil'),
                DB::raw('sum(other_bill) as o_bil')
            )
            // ->where('type', 'Owner')
            ->get();
        if ($result_ou) {
            $total_owner_utility = (float)$result_ou->w_bil + (float)$result_ou->e_bil + (float)$result_ou->g_bil + (float)$result_ou->u_bil + (float)$result_ou->s_bil + (float)$result_ou->o_bil;
            $total_utility = $total_owner_utility;
        }
        $result_salary = DB::table('employee_salaries')
            ->select(DB::raw('sum(amount) as totals'))
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->first(); // Use first() to get the first row

        if ($result_salary && $result_salary->totals > 0) {
            $total_salary = $result_salary->totals;
        }
        $result_branch = DB::table('branches')
            ->select(DB::raw('count(id) as totals'))
            ->first(); // Use first() to get the first row

        if ($result_branch && $result_branch->totals > 0) {
            $total_branch = $result_branch->totals;
        }

        return view('backend.dashboard.index');
    }

    function tableDesign()
    {
        return view('backend.dashboard.index');
    }
    function formDesign()
    {
        return view('backend.dashboard.index');
    }
}
