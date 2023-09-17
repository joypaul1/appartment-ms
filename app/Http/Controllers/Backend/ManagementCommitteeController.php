<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\ManagementCommittee;
use App\Models\Backend\MemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagementCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ManagementCommittee::where('branch_id', session('branch_id'))
            ->get();
        return view('backend.managementCommittee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member_types = MemberType::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.managementCommittee.create', compact('status', 'member_types'));
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
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'mobile'            => 'required|string|max:20',
            'pre_address'       => 'required|string|max:255',
            'per_address'       => 'required|string|max:255',
            'nid'               => 'required|string|max:20',
            'password'          => 'required|string|max:255',
            // 'salary'            => 'required',
            'joining_date'      => 'required',
            'resign_date'       => 'nullable',
            'status'            => 'required',
            'member_type_id'            => 'required',
        ]);
        try {
            $validatedData['password'] = Hash::make($request->password);
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
            if ($request->resign_date) {
                $validatedData['resign_date'] = date('Y-m-d', strtotime($request->resign_date));
            }
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('managementCommittee')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            ManagementCommittee::create($validatedData);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }


        return redirect()->route('backend.management-committee.index')->with('success', 'Tenant Created successfully.');
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
    public function edit(ManagementCommittee $managementCommittee)
    {
        $member_types = MemberType::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.managementCommittee.edit', compact('member_types', 'status', 'managementCommittee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManagementCommittee $managementCommittee)
    {
        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'mobile'            => 'required|string|max:20',
            'pre_address'       => 'required|string|max:255',
            'per_address'       => 'required|string|max:255',
            'nid'               => 'required|string|max:20',
            // 'password'          => 'nullable|string|max:255',
            // 'salary'            => 'required',
            'joining_date'      => 'required',
            'resign_date'       => 'nullable',
            'status'            => 'required',
            'member_type_id'            => 'required',
        ]);
        try {
            if ($request->password) {
                $validatedData['password'] = Hash::make($request->password);
            }
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
            if ($request->resign_date) {
                $validatedData['resign_date'] = date('Y-m-d', strtotime($request->resign_date));
            }
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('managementCommittee')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }

            $managementCommittee->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.management-committee.index')->with('success', 'Tenant Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManagementCommittee $managementCommittee)
    {
        try {
            $managementCommittee->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
