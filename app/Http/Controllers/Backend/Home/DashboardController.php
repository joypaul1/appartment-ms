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

        return view('backend.dashboard.index');
    }

    function tableDesign()  {
        return view('backend.dashboard.index');

    }
    function formDesign()  {
        return view('backend.dashboard.index');

    }
}
