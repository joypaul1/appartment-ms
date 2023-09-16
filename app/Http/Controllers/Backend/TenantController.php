<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\Floor;
use App\Models\Backend\Owner;
use App\Models\Backend\OwnerUnit;
use App\Models\Backend\Tenant;
use App\Models\Backend\Unit;
use App\Models\Backend\Year;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {




        if (auth('admin')->user()->role_type == 'owner') {
            $data = Tenant::select('*', 'fl.name as floor_name', 'uc.name as unit_name')
                ->join('owner_unit as our', 'rent_configurations.unit_id', '=', 'our.unit_id')
                ->join('floors as fl', 'fl.id', '=', 'rent_configurations.floor_id')
                ->join('unit_configurations as uc', 'uc.id', '=', 'rent_configurations.unit_id')
                ->where('our.owner_id', 13)
                ->get();
            return view('backend.tenant.owner', compact('data'));
        }

        if ($request->getRent) {
            $rent = Tenant::where('floor_id', $request->floor_id)
                ->where('unit_id', $request->unit_id)->
                // ->where('branch_id', auth('admin')->user()->branch_id)
                where('status', 1)->first();
            return response()->json(['data' => $rent]);
        }
        $data = Tenant::where('branch_id', auth('admin')->user()->branch_id)->with('unit:id,name', 'floor:id,name')->get();
        return view('backend.tenant.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id' => $i,
                'name' => $date->format('F')
            ];
        }
        $floors = Floor::active()->get(['id', 'name']);
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.tenant.create', compact('floors', 'months', 'years', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'        => 'required|string|max:20',
            'address'   => 'required|string|max:255',
            'nid'           => 'required|string|max:20',
            'password'      => 'required|string|max:255',
            'floor_id'      => 'required',
            'unit_id'       => 'required',
            'advance_rent'  => 'required',
            'rent_per_month' => 'required',
            'month_id'      => 'required',
            'year_id'       => 'required',
            'status'        => 'required',
        ]);
        try {
            $validatedData['password'] = Hash::make($request->password);
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['date'] = date('Y-m-d');
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('tenant')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            Unit::whereId($request->unit_id)->update(['status' => '1']);
            $tenant = Tenant::create($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.tenant.index')->with('success', 'Tenant Created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id' => $i,
                'name' => $date->format('F')
            ];
        }
        $floors = Floor::active()->get(['id', 'name']);
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.tenant.edit', compact('floors', 'months', 'years', 'status', 'tenant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'        => 'required|string|max:20',
            'address'   => 'required|string|max:255',
            'nid'           => 'required|string|max:20',
            'password'      => 'nullable|string|max:255',
            'floor_id'      => 'required',
            'unit_id'       => 'required',
            'advance_rent'  => 'required',
            'rent_per_month' => 'required',
            'month_id'      => 'required',
            'year_id'       => 'required',
            'status'        => 'required',
        ]);
        try {
            $validatedData['password'] = Hash::make($request->password);
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['date'] = date('Y-m-d');
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('tenant')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            if ($request->unit_id != $tenant->unit_id) {
                Unit::whereId($tenant->unit_id)->update(['status' => 0]);
                Unit::whereId($request->unit_id)->update(['status' => 1]);
            }
            $tenant->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error',  $ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.tenant.index')->with('success', 'Tenant Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        try {
            Unit::whereId($tenant->unit_id)->update(['status' => 0]);
            $tenant->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        // (new LogActivity)::addToLog('Category Deleted');
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
