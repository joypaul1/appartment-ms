<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
        $result = Owner::where('branch_id', (int)$_SESSION['objLogin']['branch_id'])
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.owner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.owner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txtOwnerName' => 'required|string|max:255',
            'txtOwnerEmail' => 'required|email|max:255',
            'txtOwnerContact' => 'required|string|max:20',
            'txtOwnerPreAddress' => 'required|string|max:255',
            'txtOwnerPerAddress' => 'required|string|max:255',
            'txtOwnerNID' => 'required|string|max:20',
            'o_password' => 'required|string|max:255', // Make sure you hash this password before saving it
            'image' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $owner = new Owner();
        $owner->o_name = $_POST['txtOwnerName'];
        $owner->o_email = $_POST['txtOwnerEmail'];
        $owner->o_contact = $_POST['txtOwnerContact'];
        $owner->o_pre_address = $_POST['txtOwnerPreAddress'];
        $owner->o_per_address = $_POST['txtOwnerPerAddress'];
        $owner->o_nid = $_POST['txtOwnerNID'];
        $owner->o_password = $o_password; // Assuming $o_password is already defined
        $owner->image = $image_url; // Assuming $image_url is already defined
        $owner->branch_id = $_SESSION['objLogin']['branch_id'];
        $owner->save();
        return redirect()->route('backend.owners.index')->with('success', 'Owner added successfully.');
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
