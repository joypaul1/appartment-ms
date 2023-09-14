<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Floor;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->getFreeUnits) {
            $units = Unit::where('floor_id', $request->Floorid)
            ->where('branch_id', auth('admin')->user()->branch_id)
            ->where('status', 0)->orderBy('id', 'asc')->get();
            return response()->json(['data' => $units]);
        }
        if ($request->getUnit) {
            $units = Unit::where('floor_id', $request->floorid)
            ->where('branch_id', auth('admin')->user()->branch_id)
            ->orderBy('id', 'asc')->get();
            return response()->json(['data' => $units]);
        }

        $data = Unit::with('branch:id,name')->with('floor:id,name')
            // ->where('branch_id', auth('admin')->user()->branch_id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.unit.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $floors = Floor::get(['id', 'name']);
        return view('backend.unit.create', compact('floors'));
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
            'floor_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $data = $validatedData;
            $data['branch_id'] = auth('admin')->user()->branch_id;
            Unit::create($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.unit.index')->with('success', 'Data Created Successfully');
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
    public function edit(Unit $unit)
    {
        $floors = Floor::get(['id', 'name']);

        return view('backend.unit.edit', compact('unit', 'floors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'floor_id' => 'required',

        ]);
        try {
            DB::beginTransaction();
            $data = $validatedData;
            $data['branch_id'] = auth('admin')->user()->branch_id;
            $unit->update($data);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.unit.index')->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {

        try {
            $unit->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        // (new LogActivity)::addToLog('Category Deleted');
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
        // $floor = Floor::find($id);

        // if (!$floor) {
        //     return redirect()->route('floors.index')->with('error', 'Floor not found.');
        // }

        // $floor->delete();

        // return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}
