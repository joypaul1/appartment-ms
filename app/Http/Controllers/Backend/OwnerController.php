<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\Owner;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->getUnitOwner) {
            $owner = Owner::whereHas('units', function ($query) use ($request) {
                $query->where('unit_configurations.floor_id', $request->floor_id)
                ->where('unit_configurations.id', $request->unit_id);
            })->first();

            return response()->json(['data' => $owner]);
        }

        $data = Owner::with('units')->

            orderBy('id', 'desc')

            ->get();
        return view('backend.owner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::whereDoesntHave('owners')->get();
        return view('backend.owner.c reate', compact('units'));
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
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'pre_address' => 'required|string|max:255',
            'per_address' => 'required|string|max:255',
            'nid' => 'required|string|max:20',
            'password' => 'required|string|max:255',
            'image' => 'nullable',
        ]);
        try {
            $validatedData['password'] = Hash::make($request->password);
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('owner')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            // dd($request->unit_id);
            $owner = Owner::create($validatedData);
            if ($request->unit_id) {
                $owner->units()->sync($request->unit_id);
            }
        } catch (\Exception $ex) {
            // return redirect()->back()->with('error',  $ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.owner.index')->with('success', 'Owner Created successfully.');
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
    public function edit(Owner $owner)
    {
        $units = Unit::get(['id', 'name']);

        return view('backend.owner.edit', compact('owner', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $owner)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'pre_address' => 'required|string|max:255',
            'per_address' => 'required|string|max:255',
            'nid' => 'required|string|max:20',
            // 'password' => 'nullable',
            // 'image' => 'nullable',
        ]);

        // Validation passed, update the data in the database
        // $owner = Owner::find($id);
        if (!$owner) {
            return redirect()->back()->with('error', 'Owner not found.');
        }
        $validatedData['branch_id'] = auth('admin')->user()->branch_id;
        // dd($request->image);

        if ($request->hasFile('image')) {
            $image =  (new Image)->dirName('owner')->file($request->image)->resizeImage(100, 100)->save();
            $validatedData['image'] = $image;
        }
        // unset($validatedData['password']);
        if ($request->password) {
            $validatedData['password'] = Hash::make($request->password);
        }
        // dd($request->password);

        // dd($validatedData);
        $owner->update($validatedData);
        if ($request->unit_id) {
            $owner->units()->sync($request->unit_id);
        }
        return redirect()->route('backend.owner.index')->with('success', 'Owner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();

        return redirect()->route('owner.index')->with('success', 'Unit deleted successfully.');
    }
}
