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
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id' => $i,
                'name' => $date->format('F')
            ];
        }

        // $floors = Floor::active()->get(['id', 'name']);
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.maintenanceCost.create', compact('months', 'years', 'status'));
    }

    public function getInvoiceNumber()
    {
        if (!OwnerUtility::latest()->first()) {
            return 1;
        } else {
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
        // dd($request->all());

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'owner_id' => 'nullable|integer',
            'date' => 'required',
            'month_id' => 'required|integer',
            'year_id' => 'required|integer',
            'amount' => 'required|numeric',
            'details' => 'nullable|string',
        ]);
        // dd($validatedData);
        try {
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['date'] = date('Y-m-d', strtotime($request->date));
            MaintenanceCost::create($validatedData);
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.maintenance-cost.index')->with('success', 'Rent Collection Created successfully.');
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
    public function edit($id)
    {
        return view('backend.maintenanceCost.edit');
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
            'floor_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'month_id' => 'required|numeric',
            'year_id' => 'required|numeric',
            'owner_name' => 'required|string',
            'owner_id' => 'required|numeric',
            'water_bill' => 'required|numeric',
            'electric_bill' => 'required|numeric',
            'gas_bill' => 'required|numeric',
            'security_bill' => 'required|numeric',
            'utility_bill' => 'required|numeric',
            'other_bill' => 'required|numeric',
            'total_utility' => 'required|numeric',
            'issue_date' => 'required',

        ]);
        try {

            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['issue_date'] = date('Y-m-d', strtotime($request->issue_date));

            $maintenanceCost->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.maintenance-cost.index')->with('success', 'Rent Collection Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
