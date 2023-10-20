<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use App\Models\Backend\BuildingInformation;
use App\Models\Backend\Complain;
use App\Models\Backend\Employee;
use App\Models\Backend\EmployeeSalary;
use App\Models\Backend\Floor;
use App\Models\Backend\Fund;
use App\Models\Backend\MaintenanceCost;
use App\Models\Backend\ManagementCommittee;
use App\Models\Backend\NoticeBoard;
use App\Models\Backend\Owner;
use App\Models\Backend\OwnerUtility;
use App\Models\Backend\RentCollection;
use App\Models\Backend\Tenant;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $noticeBoards = NoticeBoard::where('branch_id', session('branch_id'))
            ->where('end_date', '<=', date('Y-m-d'))
            ->get();

        $floorCount               = Floor::where('branch_id', session('branch_id'))->count();
        $unitCount                = Unit::where('branch_id', session('branch_id'))->count();
        $ownerCount               = Owner::where('branch_id', session('branch_id'))->count();
        $tenantCount              = Tenant::where('branch_id', session('branch_id'))->count();
        $employeeCount            = Employee::where('branch_id', session('branch_id'))->count();
        $managementCommitteeCount = ManagementCommittee::where('branch_id', session('branch_id'))->count();
        $totalRentCollection      = RentCollection::where('branch_id', session('branch_id'))->sum('total_rent');
        $totalMaintenanceCost     = MaintenanceCost::where('branch_id', session('branch_id'))->sum('amount');
        $totalFund                = Fund::where('branch_id', session('branch_id'))->sum('amount');
        $totalOwnerUtility        = OwnerUtility::where('branch_id', session('branch_id'))->sum('total_utility');
        $totalEmployeeSalary      = EmployeeSalary::where('branch_id', session('branch_id'))->sum('amount');
        $totalComplain            = Complain::where('branch_id', session('branch_id'))->count();
        $totalHouse               = BuildingInformation::where('id', session('branch_id'))->count();
        $buildingInformation      = BuildingInformation::where('id', session('branch_id'))->first();
        $depositMonthlyReport     = $this->depositMonthlyReport();
        $rentMonthlyReport        = $this->rentMonthlyReport();
        return view(
            'backend.dashboard.index',
            compact(
                'depositMonthlyReport',
                'rentMonthlyReport',
                'noticeBoards',
                'floorCount',
                'unitCount',
                'ownerCount',
                'tenantCount',
                'employeeCount',
                'managementCommitteeCount',
                'totalRentCollection',
                'totalMaintenanceCost',
                'totalFund',
                'totalOwnerUtility',
                'totalEmployeeSalary',
                'totalComplain',
                'totalHouse',
                'buildingInformation',
            )
        );
    }

    function profile()
    {
        return view('backend.admin.show');
    }

    function branch($id)
    {
        session([ 'branch_id' => $id ]);
        return back();
    }
    function language($locale)
    {
        if (!in_array($locale, [ 'en', 'bn' ])) {
            abort(400);
        }
        App::setLocale($locale);
        session()->put('locale', $locale);
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        // dd(App::getLocale());
        return back();
    }

    private function depositMonthlyReport($order = 'asc')
    {
        $currentYear = Carbon::now()->year;
        $currentYear = Carbon::now()->year;

        $monthlyReport = DB::table('bills')
            ->where('branch_id', session('branch_id'))
            ->rightJoin(
                DB::raw("
                (SELECT 1 as month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
                 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as months
            "),
                function ($join) use ($currentYear)
                {
                    $join->on(DB::raw('months.month'), '=', DB::raw('MONTH(bills.date)'))
                        ->whereYear('bills.date', $currentYear);
                }
            )
            ->select(
                DB::raw('MONTHNAME(CONCAT("2023-", months.month, "-01")) as month_name'),
                DB::raw('COALESCE(SUM(total_amount), 0) as total_amount')
            )
            ->groupBy('months.month', 'month_name')
            ->orderBy('months.month', $order)
            ->get();
        return [ 'monthlyReport' => $monthlyReport->pluck('total_amount')->toArray() ];
    }

    private function rentMonthlyReport($order = 'asc')
    {
        // dd(date('Y'));
        $currentYear   = Carbon::now()->year;
        $monthlyReport = DB::table('rent_collections')
            ->where('branch_id', session('branch_id'))
            ->rightJoin(
                DB::raw("
            (SELECT 1 as month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
             UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
             UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as months
        "),
                function ($join) use ($currentYear)
                {
                    $join->on(DB::raw('months.month'), '=', DB::raw('MONTH(rent_collections.issue_date)'))
                        ->whereYear('rent_collections.issue_date', $currentYear);
                    // ->where('year_id' , DB::raw('(SELECT name FROM year_configurations WHERE name = '.date('Y').')'), $currentYear);
                }
            )
            ->select(
                DB::raw('MONTHNAME(CONCAT("2023-", months.month, "-01")) as month_name'),
                DB::raw('COALESCE(SUM(total_rent), 0) as total_rent')
            )
            ->groupBy('months.month', 'month_name')
            ->orderBy('months.month', $order)
            ->get();



        return [ 'monthlyReport' => $monthlyReport->pluck('total_rent')->toArray() ];
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
