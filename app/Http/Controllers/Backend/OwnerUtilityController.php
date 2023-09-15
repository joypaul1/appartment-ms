<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\Floor;
use App\Models\Backend\OwnerUtility;
use App\Models\Backend\Year;
use DateTime;
use Illuminate\Http\Request;

class OwnerUtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $OwnerUtilitys=OwnerUtility::get();
        return view('backend.ownerUtility.index', compact('OwnerUtilitys'));
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

        $floors = Floor::active()->get(['id', 'name']);
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.ownerUtility.create', compact('floors', 'months', 'years', 'status'));
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
            'floor_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'month_id' => 'required|numeric',
            'year_id' => 'required|numeric',
            'renter_name' => 'required|string',
            'rent' => 'required',
            'rent_id' => 'required|numeric',
            'water_bill' => 'required|numeric',
            'electric_bill' => 'required|numeric',
            'gas_bill' => 'required|numeric',
            'security_bill' => 'required|numeric',
            'utility_bill' => 'required|numeric',
            'other_bill' => 'required|numeric',
            'total_rent' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        try {
            $validatedData['rent_type'] = 'Rented';
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['date'] = date('Y-m-d');
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('owner_utility')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            OwnerUtility::create($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.owner-utility.index')->with('success', 'Rent Collection Created successfully.');
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
        return view('backend.ownerUtility.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,OwnerUtility $OwnerUtility)
    {
        $validatedData = $request->validate([
            'floor_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'month_id' => 'required|numeric',
            'year_id' => 'required|numeric',
            'renter_name' => 'required|string',
            'rent' => 'required',
            'rent_id' => 'required|numeric',
            'water_bill' => 'required|numeric',
            'electric_bill' => 'required|numeric',
            'gas_bill' => 'required|numeric',
            'security_bill' => 'required|numeric',
            'utility_bill' => 'required|numeric',
            'other_bill' => 'required|numeric',
            'total_rent' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        try {
            $validatedData['rent_type'] = 'Rented';
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('owner_utility')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            $OwnerUtility->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.ownerUtility.index')->with('success', 'Rent Collection Updated successfully.');

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
