<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Backend\Owner;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            $owner = Owner::where('branch_id', session('branch_id'))->whereHas('units', function ($query) use ($request)
            {
                $query->where('unit_configurations.floor_id', $request->floor_id)
                    ->where('unit_configurations.id', $request->unit_id);
            })->first();
            return response()->json([ 'data' => $owner ]);
        }
        $data = Owner::where('branch_id', session('branch_id'))->with('units')->orderBy('id', 'desc')->get();
        if (auth('admin')->user()->role_type == 'employee') {
            return view('backend.owner.employee', compact('data'));
        }
        return view('backend.owner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::where('branch_id', session('branch_id'))->whereDoesntHave('owners')->get();
        return view('backend.owner.create', compact('units'));
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
            'name'        => 'required|string|max:255',
            'email'       => [
                'required',
                'email',
                'max:255',
                Rule::unique('owners', 'email'),
                Rule::unique('admins', 'email'),
            ],
            'mobile'      => [
                'required',
                'string',
                'max:255',
                Rule::unique('owners', 'mobile'),
                Rule::unique('admins', 'mobile'),
            ],
            'pre_address' => 'required|string|max:255',
            'per_address' => 'required|string|max:255',
            'nid'         => 'required|string|max:30', // Adjust the max length to match the expected length.
            'password'    => 'required|string|max:20',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif', // Add image validation rules as needed.
        ]);

        try {

            $validatedData['branch_id'] = session('branch_id');
            if ($request->hasfile('image')) {
                $image                  = (new Image)->dirName('owner')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            $owner = Owner::create($validatedData);

            $data['name']      = ($request->name);
            $data['email']     = ($request->email);
            $data['mobile']    = ($request->mobile);
            $data['branch_id'] = $validatedData['branch_id'];
            $data['role_type'] = 'owner';
            if ($request->hasFile('image')) {
                $data['image'] = $validatedData['image'];
            }
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
                Admin::create($data);
            }

            if ($request->unit_id) {
                $owner->units()->sync($request->unit_id);
            }
        }
        catch (\Exception $ex) {
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
        $units = Unit::get([ 'id', 'name' ]);

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
            'name'        => 'required|string|max:255',
            'email'       => [
                'required',
                'email',
                Rule::unique('owners')->ignore($owner->id),
            ],
            'mobile'      => [
                'required',
                'string',
                Rule::unique('owners')->ignore($owner->id),
            ],
            'pre_address' => 'required|string|max:255',
            'per_address' => 'required|string|max:255',
            'nid'         => 'required|string|max:30',
            'password'    => 'required|string|max:20',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif', // Add image validation rules as needed.

        ]);

        // Validation passed, update the data in the database
        if (!$owner) {
            return redirect()->back()->with('error', 'Owner not found.');
        }
        $validatedData['branch_id'] = session('branch_id');
        $validatedData['image']     = $owner->image;
        if ($request->hasFile('image')) {
            $image                  = (new Image)->dirName('owner')->file($request->image)->resizeImage(100, 100)->save();
            $validatedData['image'] = $image;
        }


        //admin data
        $data['name']      = ($request->name);
        $data['email']     = ($request->email);
        $data['mobile']    = ($request->mobile);
        $data['branch_id'] = $validatedData['branch_id'];
        $data['role_type'] = 'owner';

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $validatedData['image'];
        }
        $admin = Admin::where('email', $owner->email)->where('mobile', $owner->mobile)->first();
        if ($admin) {
            $admin->update($data);
        }
        else {
            Admin::create($data);
        }
        //admin data

        if ($request->unit_id) {
            $owner->units()->sync($request->unit_id);
        }
        $owner->update($validatedData);

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
        try {
            $owner = Owner::findOrFail($id);
            Admin::where('email', $owner->email)->where('name', $owner->name)->where('mobile', $owner->mobile)->delete();
            $owner->delete();
        }
        catch (\Exception $ex) {
            return response()->json([ 'status' => false, 'mes' => 'Something went wrong!' ]);
        }
        return response()->json([ 'status' => true, 'mes' => 'Data Deleted Successfully' ]);
    }
}
