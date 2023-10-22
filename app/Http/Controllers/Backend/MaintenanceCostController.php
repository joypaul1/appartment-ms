<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Helpers\InvoiceNumber;
use App\Http\Controllers\Controller;
use App\Models\Backend\Floor;
use App\Models\Backend\MaintenanceCost;
use App\Models\Backend\OwnerUtility;
use App\Models\Backend\Year;
use DateTime;
use Illuminate\Http\Request;

class MaintenanceCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('admin')->user()->role_type == 'owner') {
            $maintenanceCosts = MaintenanceCost::where('branch_id', session('branch_id'))
                ->with('month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            return view('backend.maintenanceCost.owner', compact('maintenanceCosts'));
        }
        $maintenanceCosts = MaintenanceCost::with('month:id,name', 'year:id,name', 'branch:id,name')
            ->orderBy('id', 'desc')->get();
        return view('backend.maintenanceCost.index', compact('maintenanceCosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $date     = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id'   => $i,
                'name' => $date->format('F')
            ];
        }
        $years  = Year::get([ 'id', 'name' ]);
        $status = [ [ 'id' => 1, 'name' => 'active' ], [ 'id' => 0, 'name' => 'inactive' ] ];
        return view('backend.maintenanceCost.create', compact('months', 'years', 'status'));
    }

    public function getInvoiceNumber()
    {
        if (!OwnerUtility::latest()->first()) {
            return 1;
        }
        else {
            return OwnerUtility::latest()->first()->invoice_number + 1;
        }
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
            'title'    => 'required|string|max:255',
            'date'     => 'required',
            'month_id' => 'required|integer',
            'year_id'  => 'required|integer',
            'amount'   => 'required|numeric',
            'details'  => 'nullable|string',
        ]);
        try {
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['date']      = date('Y-m-d', strtotime($request->date));
            MaintenanceCost::create($validatedData);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.maintenance-cost.index')->with('success', 'Data Created successfully.');
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
    public function edit(MaintenanceCost $maintenanceCost)
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $date     = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id'   => $i,
                'name' => $date->format('F')
            ];
        }
        $years  = Year::get([ 'id', 'name' ]);
        $status = [ [ 'id' => 1, 'name' => 'active' ], [ 'id' => 0, 'name' => 'inactive' ] ];
        return view('backend.maintenanceCost.edit', compact('maintenanceCost', 'months', 'years', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceCost $maintenanceCost)
    {
        $validatedData = $request->validate([
            'title'    => 'required|string|max:255',
            'date'     => 'required',
            'month_id' => 'required|integer',
            'year_id'  => 'required|integer',
            'amount'   => 'required|numeric',
            'details'  => 'nullable|string',
        ]);
        try {
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['date']      = date('Y-m-d', strtotime($request->date));
            $maintenanceCost->update($validatedData);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.maintenance-cost.index')->with('success', 'Rent Collection Created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceCost $maintenanceCost)
    {
        try {
            $maintenanceCost->delete();
        }
        catch (\Exception $ex) {
            return response()->json([ 'status' => false, 'mes' => 'Something went wrong!This was relationship Data.' ]);
        }
        return response()->json([ 'status' => true, 'mes' => 'Data Deleted Successfully' ]);
    }
}
