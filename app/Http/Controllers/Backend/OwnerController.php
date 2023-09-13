<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\Owner;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $data = Owner::with('units')->
            // where('branch_id',auth('admin')->user()->branch_id)
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
        $units = Unit::get(['id', 'name']);
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
        // dd($request->all());
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
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('owner')->file($request->image)->resizeImage(200, 200)->save();
                $validatedData['image'] = $image;
            }
            // dd($validatedData);
            $owner = Owner::create($validatedData);
            if ($request->unit_id) {
                $owner->units()->sync($request->unit_id);
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('error',  $ex->getMessage());
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
    public function edit($id)
    {
        return view('backend.owner.edit');
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
        $validator = Validator::make($request->all(), [
            'txtOwnerName' => 'required|string|max:255',
            'txtOwnerEmail' => 'required|email|max:255',
            'txtOwnerContact' => 'required|string|max:20',
            'txtOwnerPreAddress' => 'required|string|max:255',
            'txtOwnerPerAddress' => 'required|string|max:255',
            'txtOwnerNID' => 'required|string|max:20',
            'o_password' => 'required|string|max:255',
            'image' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validation passed, update the data in the database
        $owner = Owner::find($ownerId);
        if (!$owner) {
            return redirect()->back()->with('error', 'Owner not found.');
        }

        $owner->o_name = $request->input('txtOwnerName');
        $owner->o_email = $request->input('txtOwnerEmail');
        $owner->o_contact = $request->input('txtOwnerContact');
        $owner->o_pre_address = $request->input('txtOwnerPreAddress');
        $owner->o_per_address = $request->input('txtOwnerPerAddress');
        $owner->o_nid = $request->input('txtOwnerNID');
        $owner->o_password = bcrypt($request->input('o_password')); // Hash the password
        $owner->image = $request->input('image');
        $owner->branch_id = $_SESSION['objLogin']['branch_id'];
        $owner->save();

        return redirect()->route('owners.index')->with('success', 'Owner updated successfully.');
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
