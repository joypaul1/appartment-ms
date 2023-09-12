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
        $result_ou = DB::table('fairs')
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
            $total_owner_utility = (float)$result_ou[0]->w_bil + (float)$result_ou[0]->e_bil + (float)$result_ou[0]->g_bil + (float)$result_ou[0]->u_bil + (float)$result_ou[0]->s_bil + (float)$result_ou[0]->o_bil;
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

        $_graph_deposit = [];
        $branchId = 7;
        $currentYear = date('Y');

        $result_deposit = DB::select(DB::raw("
            SELECT sum(`total_amount`) as total, m.name as month_name, y.year as year_name, b.`month` as bill_month FROM bills b
            INNER JOIN bill_types bt ON bt.id = b.bill_type_id
            INNER JOIN month_setups m ON m.id = b.`month`
            INNER JOIN year_configurations y ON y.id = b.year
            WHERE b.branch_id = :branchId and y.year = :currentYear
            GROUP BY b.`month`, m.name, y.year
            ORDER BY b.`month` ASC
        "), ['branchId' => $branchId, 'currentYear' => $currentYear]);


        foreach ($result_deposit as $row_deposit_total) {
            $_graph_deposit[$row_deposit_total->bill_month] = $row_deposit_total;
        }

        $graph_data = '';
        if (!empty($_graph_deposit)) {
            for ($i = 1; $i <= 12; $i++) {
                if (isset($_graph_deposit[$i])) {
                    $graph_data .= $_graph_deposit[$i]->total . ',';
                } else {
                    $graph_data .= '0,';
                }
            }
        }

        if (!empty($graph_data)) {
            $monthly_bill_data = rtrim($graph_data, ',');
        }



        $_graph_rent = [];

        $result_rent = DB::table('fairs')
            ->select(DB::raw('SUM(total_rent) as total'), 'month_id')
            ->where('branch_id', $branchId)
            ->where('year', $currentYear)
            ->groupBy('month_id')
            ->orderBy('month_id', 'asc')
            ->get();

        foreach ($result_rent as $row_rent_total) {
            $_graph_rent[$row_rent_total->month_id] = $row_rent_total;
        }

        $rent_data = '';

        if (!empty($_graph_rent)) {
            for ($i = 1; $i <= 12; $i++) {
                if (isset($_graph_rent[$i])) {
                    $rent_data .= $_graph_rent[$i]->total . ',';
                } else {
                    $rent_data .= '0,';
                }
            }
        }

        if (!empty($rent_data)) {
            $monthly_rent_data = rtrim($rent_data, ',');
        }


        $total_complain = 0;

        return $result = DB::table('complains as c')
            ->select(DB::raw('count(id) as total_complain'))
            ->where('c.branch_id', $branchId)
            ->first();

        if ($result) {
            $total_complain = $result->total_complain;
        }


        return view('backend.dashboard.index');
    }

    function tableDesign()
    {
        return view('backend.dashboard.tableDesign');
    }
    function formDesign()
    {
        return view('backend.dashboard.formDesign');
    }
}
