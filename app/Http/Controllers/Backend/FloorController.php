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
        return $data = Floor::
            // ->where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            orderBy('id', 'DESC')
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
        $floor = new Floor();
        $floor->floor_no = $_POST['txtFloor'];
        $floor->branch_id = $_SESSION['objLogin']['branch_id'];
        $floor->save();
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
        return view('backend.floor.edit');
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
        $floor = Floor::find($id);

        if (!$floor) {
            return redirect()->route('floors.index')->with('error', 'Floor not found.');
        }

        $floor->floor_no = $request->input('txtFloor');
        $floor->branch_id = $_SESSION['objLogin']['branch_id'];
        $floor->save();

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $floor = Floor::find($id);

        if (!$floor) {
            return redirect()->route('floors.index')->with('error', 'Floor not found.');
        }

        $floor->delete();

        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}
