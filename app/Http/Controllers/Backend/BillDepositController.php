<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\BillDeposit;
use App\Models\Backend\BillType;
use App\Models\Backend\Fund;
use App\Models\Backend\Owner;
use App\Models\Backend\Year;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillDepositController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funds = BillDeposit::with('owner:id,name', 'month:id,name', 'year:id,name', 'branch:id,name')
            ->orderBy('id', 'desc')->get();

        return view('backend.billDeposit.index', compact('funds'));
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

        $billTypes = BillType::get();
        $years = Year::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.billDeposit.create', compact('months', 'billTypes', 'years', 'status'));
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
            'bill_type_id' => 'required|integer',
            'date' => 'required',
            'month_id' => 'required|integer',
            'year_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'deposit_account_name' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);
        // dd($validatedData);
        try {
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['date'] = date('Y-m-d', strtotime($request->date));
            BillDeposit::create($validatedData);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.bill-deposit.index')->with('success', 'BillDeposit Created successfully.');
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
        return view('backend.billDeposit.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillDeposit $billDeposit)
    {
        $validatedData = $request->validate([
            'bill_type_id' => 'required|integer',
            'date' => 'required',
            'month_id' => 'required|integer',
            'year_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'deposit_account_name' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);
        try {

            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['date'] = date('Y-m-d', strtotime($request->date));

            $billDeposit->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.bill-deposit.index')->with('success', 'BillDeposit Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillDeposit $billDeposit)
    {
        try {
            DB::beginTransaction();
            $billDeposit->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => false, 'mes' => 'Something went wrong!']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
