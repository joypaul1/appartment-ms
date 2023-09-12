<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $data = DB::table('unit_configurations as u')
            ->select('f.floor_no', 'u.unit_no', 'u.id')
            ->join('floors as f', 'f.id', '=', 'u.floor_no')
            // ->where('u.branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->orderBy('u.id', 'ASC')
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
        return view('backend.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unit = new Unit();
        $unit->floor_no = $_POST['ddlFloor'];
        $unit->unit_no = $_POST['txtUnit'];
        $unit->branch_id = $_SESSION['objLogin']['branch_id'];
        $unit->save();
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
        $unit = Unit::findOrFail($id); // Find the unit by its ID
        return view('backend.unit.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ddlFloor' => 'required', // Add validation rules for your fields here
            'txtUnit' => 'required',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->floor_no = $request->input('ddlFloor');
        $unit->unit_no = $request->input('txtUnit');
        // Update other fields as needed
        $unit->save();

        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }
}
