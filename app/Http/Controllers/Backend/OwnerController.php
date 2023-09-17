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


        $data = Owner::with('units')->orderBy('id', 'desc')->get();
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:owners,email',
            'mobile' => 'required|string|max:20|unique:owners,mobile',
            'pre_address' => 'required|string|max:255',
            'per_address' => 'required|string|max:255',
            'nid' => 'required|string|max:20',
            'password' => 'required|string|max:255',
            'image' => 'nullable',
        ]);
        try {
            $validatedData['password'] = Hash::make($request->password);
            $validatedData['branch_id'] = session('branch_id');
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('owner')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            // dd($request->unit_id);
            $owner = Owner::create($validatedData);

            $data['name'] = ($request->name);
            $data['email'] = ($request->email);
            $data['mobile'] = ($request->mobile);
            $data['branch_id'] =  $validatedData['branch_id'];
            $data['role_type'] =  'owner';
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                $data['image'] =  $validatedData['image'];
            }
            Admin::where('email', $data['email'])->where('name', $data['name'])->where('mobile', $data['mobile'])
                ->updateOrCreate($data);

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
            'email'             => 'required|email|max:255|unique:owners,email,' . $owner->id,
            'mobile'            => 'required|string|max:20|unique:owners,mobile,' . $owner->id,
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
        $validatedData['branch_id'] = session('branch_id');
        // dd($validatedData['branch_id'] );
        if ($request->hasFile('image')) {
            $image =  (new Image)->dirName('owner')->file($request->image)->resizeImage(100, 100)->save();
            $validatedData['image'] = $image;
        }
        $owner->update($validatedData);


        $data['name'] = ($request->name);
        $data['email'] = ($request->email);
        $data['mobile'] = ($request->mobile);
        $data['branch_id'] =  $validatedData['branch_id'];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $data['image'] =  $validatedData['image'];
        }
        Admin::where('email', $data['email'])->where('name', $data['name'])->where('mobile', $data['mobile'])
            ->updateOrCreate($data);

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
        try {
            $owner = Owner::findOrFail($id);
            $owner->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => 'Something went wrong!']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
