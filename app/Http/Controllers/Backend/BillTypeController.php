<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\BillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BillType::
            where('branch_id', session('branch_id'))
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.bill_type.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bill_type.create');
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
            'name' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $data               = $validatedData;
            $data['id']         = BillType::first() ? BillType::orderBy('id', 'DESC')->first()->id + 1 : 1;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $data['branch_id']  = session('branch_id');
            BillType::insert($data);
            DB::commit();
        }
        catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.site-config.bill-type.index')->with('success', 'Data Created Successfully');
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
    public function edit(BillType $billType)
    {
        return view('backend.bill_type.edit', compact('billType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillType $billType)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $data              = $validatedData;
            $data['branch_id'] = session('branch_id');
            $billType->update($data);
            DB::commit();
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.site-config.bill-type.index')->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillType $billType)
    {

        try {
            DB::beginTransaction();
            $billType->delete();
            DB::commit();
        }
        catch (\Exception $ex) {
            DB::rollback();
            return response()->json([ 'status' => false, 'mes' => 'Something went wrong!This was relationship Data.' ]);
        }
        return response()->json([ 'status' => true, 'mes' => 'Data Deleted Successfully' ]);
    }
}
