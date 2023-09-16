<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\MonthConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MonthConfiguration::
            orderBy('id', 'DESC')
            ->get();
        return view('backend.month_config.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.month_config.create');
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
            $data = $validatedData;
            $data['id'] =MonthConfiguration::first()?MonthConfiguration:: orderBy('id', 'DESC')->first()->id +1: 1 ;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            MonthConfiguration::insert($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
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
    public function edit($id)
    {
        $monthConfiguration = MonthConfiguration::find($id);
        return view('backend.month_config.edit', compact('monthConfiguration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthConfiguration $monthConfiguration)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $data = $validatedData;
            $data['branch_id'] = auth('admin')->user()->branch_id;
            $monthConfiguration->update($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.site-config.month.index')->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthConfiguration $monthConfiguration)
    {

        try {
            DB::beginTransaction();
            $monthConfiguration->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
