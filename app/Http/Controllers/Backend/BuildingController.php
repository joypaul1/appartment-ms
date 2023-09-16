<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\BuildingInformation;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = BuildingInformation::all();
        return view('backend.building.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];

        return view('backend.building.create', compact('status'));
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
            'mobile' => 'required|string|max:15', // Adjust max length if necessary.
            'email' => 'required|email|max:255',
            'security_guard_mobile' => 'nullable|string|max:15', // Adjust max length if necessary.
            'secretary_mobile' => 'nullable|string|max:15', // Adjust max length if necessary.
            'moderator_mobile' => 'nullable|string|max:15', // Adjust max length if necessary.
            'address' => 'required|string|max:255',
            'status' => 'required|boolean',
            'builder_name' => 'nullable|string|max:255', // Adjust max length if necessary.
            'builder_address' => 'nullable|string|max:255', // Adjust max length if necessary.
            'building_rules' => 'nullable|string', // No specific max length for text.
        ]);
        try {

            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            if ($request->hasfile('building_image')) {
                $image =  (new Image)->dirName('building_image')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['building_image'] = $image;
            }
            BuildingInformation::create($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error',  $ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.site-config.building.index')->with('success', 'Data Created successfully.');
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
        // dd($buildingInformation);
        $buildingInformation = BuildingInformation::whereId($id)->first();
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.building.edit', compact('status', 'buildingInformation'));
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15', // Adjust max length if necessary.
            'email' => 'required|max:255',
            'security_guard_mobile' => 'nullable|string|max:15', // Adjust max length if necessary.
            'secretary_mobile' => 'nullable|string|max:15', // Adjust max length if necessary.
            'moderator_mobile' => 'nullable|string|max:15', // Adjust max length if necessary.
            'address' => 'required|string|max:255',
            'status' => 'required|boolean',
            'builder_name' => 'nullable|string|max:255', // Adjust max length if necessary.
            'builder_address' => 'nullable|string|max:255', // Adjust max length if necessary.
            'building_rules' => 'nullable|string', // No specific max length for text.
        ]);
        // dd( $validatedData );
        // Validation passed, update the data in the database
        $buildingInformation = BuildingInformation::whereId($id)->first();

        if (!$buildingInformation) {
            return redirect()->back()->with('error', 'Data not found.');
        }
        $validatedData['branch_id'] = auth('admin')->user()->branch_id;
        if ($request->hasFile('building_image')) {
            $image =  (new Image)->dirName('building_image')->file($request->image)->resizeImage(100, 100)->save();
            $validatedData['building_image'] = $image;
        }
        $buildingInformation->update($validatedData);

        return redirect()->route('backend.site-config.building.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $buildingInformation = BuildingInformation::whereId($id)->first();
            $buildingInformation->delete();
        } catch (\Throwable $th) {
            return redirect()->route('owner.index')->with('error', 'Somethings Is Wrong!');
        }
        return redirect()->route('owner.index')->with('success', 'Data deleted successfully.');
    }
}
