<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Fund;
use App\Models\Backend\MaintenanceCost;
use App\Models\Backend\Owner;
use App\Models\Backend\Year;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('admin')->user()->role_type == 'owner') {
            $owner = Owner::where('email', auth('admin')->user()->email)->where('mobile', auth('admin')->user()->mobile)
                ->where('branch_id', session('branch_id'))->first();

            $funds = Fund::where('branch_id', session('branch_id'))
                ->with('owner:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            $maintenanceCosts = MaintenanceCost::where('branch_id', session('branch_id'))->with('month:id,name', 'year:id,name', 'branch:id,name')
                ->orderBy('id', 'desc')->get();
            return view('backend.fund.owner', compact('funds', 'maintenanceCosts'));
        }
        $funds = Fund::where('branch_id', session('branch_id'))
            ->with('owner:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
            ->orderBy('id', 'desc')->get();

        return view('backend.fund.index', compact('funds'));
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

        $owners = Owner::where('branch_id', session('branch_id'))->get();
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.fund.create', compact('months', 'years', 'status', 'owners'));
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
            'owner_id' => 'required|integer',
            'date' => 'required|date',
            'month_id' => 'required|integer',
            'year_id' => 'required|integer',
            'amount' => 'required|numeric',
            'purpose' => 'nullable|string',
        ]);
        try {
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['date'] = date('Y-m-d', strtotime($request->date));
            Fund::create($validatedData);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.fund.index')->with('success', 'Fund Created successfully.');
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
    public function edit(Fund $fund)
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id' => $i,
                'name' => $date->format('F')
            ];
        }

        $owners = Owner::where('branch_id', session('branch_id'))->get();
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.fund.edit', compact('months', 'fund', 'years', 'status', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fund $fund)
    {
        $validatedData = $request->validate([
            'owner_id' => 'required|integer',
            'date' => 'required|date',
            'month_id' => 'required|integer',
            'year_id' => 'required|integer',
            'amount' => 'required|numeric',
            'purpose' => 'nullable|string',
        ]);
        try {

            $validatedData['branch_id'] = session('branch_id');
            $validatedData['date'] = date('Y-m-d', strtotime($request->date));

            $fund->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.fund.index')->with('success', 'Fund Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund)
    {
        try {
            DB::beginTransaction();
            $fund->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => false, 'mes' => 'Something went wrong!']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
