<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\Employee;
use App\Models\Backend\MemberType;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::where('branch_id', auth('admin')->user()->branch_id)->get();
        return view('backend.employee.index', compact('data'));
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
        return view('backend.employee.create', compact('status', 'member_types'));
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
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'mobile'            => 'required|string|max:20',
            'pre_address'       => 'required|string|max:255',
            'per_address'       => 'required|string|max:255',
            'nid'               => 'required|string|max:20',
            'password'          => 'required|string|max:255',
            'salary'            => 'required',
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
                $image =  (new Image)->dirName('employee')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            $employee = Employee::create($validatedData);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.employee.index')->with('success', 'Employee Created successfully.');
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
    public function edit(Employee $employee)
    {
        $member_types = MemberType::get(['id', 'name']);
        $status = [['id' => 1, 'name' => 'active'], ['id' => 0, 'name' => 'inactive']];
        return view('backend.employee.edit', compact('member_types', 'status', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'mobile'            => 'required|string|max:20',
            'pre_address'       => 'required|string|max:255',
            'per_address'       => 'required|string|max:255',
            'nid'               => 'required|string|max:20',
            // 'password'          => 'nullable|string|max:255',
            'salary'            => 'required',
            'joining_date'      => 'required',
            'resign_date'       => 'nullable',
            'status'            => 'required',
            'member_type_id'            => 'required',
        ]);
        try {
            if($request->password){
                $validatedData['password'] = Hash::make($request->password);
            }
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
            if ($request->resign_date) {
                $validatedData['resign_date'] = date('Y-m-d', strtotime($request->resign_date));
            }
            if ($request->hasfile('image')) {
                $image =  (new Image)->dirName('employee')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }

            $employee->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error',  $ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.employee.index')->with('success', 'Employee Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        // (new LogActivity)::addToLog('Category Deleted');
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
