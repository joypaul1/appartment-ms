<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Helpers\InvoiceNumber;
use App\Http\Controllers\Controller;
use App\Models\Backend\Floor;
use App\Models\Backend\Owner;
use App\Models\Backend\Rent;
use App\Models\Backend\RentCollection;
use App\Models\Backend\Tenant;
use App\Models\Backend\Year;
use DateTime;
use Illuminate\Http\Request;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('admin')->user()->role_type == 'owner') {
            $owner = Owner::where('email', auth('admin')->user()->email)->where('mobile', auth('admin')->user()->mobile)->first();

            $rentCollections = RentCollection::select('*', 'fl.name as floor_name', 'uc.name as unit_name')
                ->join('owner_unit as our', 'rent_collections.unit_id', '=', 'our.unit_id')
                ->join('floors as fl', 'fl.id', '=', 'rent_collections.floor_id')
                ->join('unit_configurations as uc', 'uc.id', '=', 'rent_collections.unit_id')
                ->where('our.owner_id', $owner->id)
                ->get();
            return view('backend.rent.owner', compact('rentCollections'));
        }
        if (auth('admin')->user()->role_type == 'tenant') {
            $tenant = Tenant::where('email', auth('admin')->user()->email)->where('mobile', auth('admin')->user()->mobile)->first();
            $rentCollections = RentCollection::where('tenant_id', $tenant->id)->get();
            return view('backend.rent.owner', compact('rentCollections'));
        }

        $rentCollections = RentCollection::with('tenant:id,name', 'floor:id,name', 'unit:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
            ->orderBy('id', 'desc')->get();
        return view('backend.rent.index', compact('rentCollections'));
    }
    public function getInvoiceNumber()
    {
        if (!RentCollection::latest()->first()) {
            return 1;
        } else {
            return RentCollection::latest()->first()->invoice_number + 1;
        }
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
        $status = [['id' => 1, 'name' => 'Paid'], ['id' => 0, 'name' => 'Due']];
        return view('backend.rent.create', compact('floors', 'months', 'years', 'status'));
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
            'issue_date' => 'required',
        ]);
        try {
            $validatedData['invoice_number'] = (new InvoiceNumber)->invoice_num($this->getInvoiceNumber());
            $validatedData['tenant_id'] = $request->rent_id;
            $validatedData['rent_type'] = 'Rented';
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['issue_date'] = date('Y-m-d', strtotime($request->issue_date));
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('rent')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            RentCollection::create($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.rent.index')->with('success', 'Rent Collection Created successfully.');
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
        return view('backend.rent.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RentCollection $rentCollection)
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
            'issue_date' => 'required',
        ]);
        try {
            $validatedData['tenant_id'] = $request->rent_id;
            $validatedData['rent_type'] = 'Rented';
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['issue_date'] = date('Y-m-d', strtotime($request->issue_date));
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('rent')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            $rentCollection->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.rent.index')->with('success', 'Rent Collection Updated successfully.');
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
