<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Floor::where('branch_id', session('branch_id'))->with('branch:id,name')
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.floor.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.floor.create');
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
            $data['branch_id'] = session('branch_id');
            Floor::create($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.floor.index')->with('success', 'Floor Created Successfully');
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
    public function edit(Floor $floor)
    {
        return view('backend.floor.edit', compact('floor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Floor $floor)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $data = $validatedData;
            $data['branch_id'] = session('branch_id');
            $floor->update($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.floor.index')->with('success', 'Floor Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Floor $floor)
    {

        try {
            DB::beginTransaction();
            $floor->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);

    }
}
