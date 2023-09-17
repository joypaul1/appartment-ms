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
        $floorCount = Floor::where('branch_id', session('branch_id'))->count();
        $unitCount = Unit::where('branch_id', session('branch_id'))->count();
        $ownerCount = Owner::where('branch_id', session('branch_id'))->count();
        $tenantCount = Tenant::where('branch_id', session('branch_id'))->count();
        $employeeCount = Employee::where('branch_id', session('branch_id'))->count();
        $managementCommitteeCount = ManagementCommittee::where('branch_id', session('branch_id'))->count();
        $totalRentCollection = RentCollection::where('branch_id', session('branch_id'))->sum('total_rent');
        $totalMaintenanceCost = MaintenanceCost::where('branch_id', session('branch_id'))->sum('amount');
        $totalFund = Fund::where('branch_id', session('branch_id'))->sum('amount');
        $totalOwnerUtility = OwnerUtility::where('branch_id', session('branch_id'))->sum('total_utility');
        $totalEmployeeSalary = EmployeeSalary::where('branch_id', session('branch_id'))->sum('amount');
        $totalComplain = Complain::where('branch_id', session('branch_id'))->count();
        $totalHouse = BuildingInformation::where('id', session('branch_id'))->count();
        $buildingInformation = BuildingInformation::where('id', session('branch_id'))->first();

        return view(
            'backend.dashboard.index',
            compact(
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
    function branch($id)
    {
        session(['branch_id' => $id]);
        return back();
    }
    function language($locale)
    {
        if (!in_array($locale, ['en', 'bn'])) {
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



    function tableDesign()
    {
        return view('backend.dashboard.tableDesign');
    }
    function formDesign()
    {
        return view('backend.dashboard.formDesign');
    }
}
