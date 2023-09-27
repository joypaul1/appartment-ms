<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\MemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MemberType::
            orderBy('id', 'DESC')
            ->get();
        return view('backend.member_type.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.member_type.create');
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
            $data['id'] =MemberType::first()?MemberType:: orderBy('id', 'DESC')->first()->id +1: 1 ;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            MemberType::insert($data);
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
    public function edit(MemberType $memberType)
    {
        return view('backend.member_type.edit', compact('billType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberType $memberType)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $data = $validatedData;
            $data['branch_id'] = session('branch_id');
            $memberType->update($data);
            DB::commit();
        } catch (\Exception $ex) {
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
    public function destroy(MemberType $memberType)
    {

        try {
            DB::beginTransaction();
            $memberType->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
