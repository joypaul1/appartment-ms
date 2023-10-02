<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Backend\Employee;
use App\Models\Backend\MemberType;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (auth('admin')->user()->role_type == 'owner') {
            $data = Employee::select('employees.*', 'mt.name as designation')
                ->join('member_types as mt', 'mt.id', '=', 'employees.member_type_id')
                ->where('employees.branch_id', session('branch_id'))
                ->get();
            return view('backend.employee.owner', compact('data'));
        }

        if ($request->getSalary) {
            return response()->json([ 'data' => Employee::whereId($request->Employeeid)->first()->salary ]);
        }


        $data = Employee::with('memberType:id,name')->where('branch_id', session('branch_id'))
            ->get();
        return view('backend.employee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member_types = MemberType::get([ 'id', 'name' ]);
        $status       = [ [ 'id' => 1, 'name' => 'active' ], [ 'id' => 0, 'name' => 'inactive' ] ];
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
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email'),
                Rule::unique('admins', 'email'),
            ],
            'mobile'         => [
                'required',
                'mobile',
                'max:255',
                Rule::unique('employees', 'mobile'),
                Rule::unique('admins', 'mobile'),
            ],
            'pre_address'    => 'required|string|max:255',
            'per_address'    => 'required|string|max:255',
            'nid'            => 'required|string|max:20',
            'password'       => 'required|string|max:255',
            'salary'         => 'required',
            'joining_date'   => 'required',
            'resign_date'    => 'nullable',
            'status'         => 'required',
            'member_type_id' => 'required',
        ]);
        try {
            $validatedData['branch_id']    = session('branch_id');
            $validatedData['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
            if ($request->resign_date) {
                $validatedData['resign_date'] = date('Y-m-d', strtotime($request->resign_date));
            }
            if ($request->hasfile('image')) {
                $image                  = (new Image)->dirName('employee')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }
            $employee          = Employee::create($validatedData);
            $data['name']      = ($request->name);
            $data['email']     = ($request->email);
            $data['mobile']    = ($request->mobile);
            $data['branch_id'] = $validatedData['branch_id'];
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                $data['image'] = $validatedData['image'];
            }
            Admin::where('email', $data['email'])->where('name', $data['name'])->where('mobile', $data['mobile'])
                ->updateOrCreate($data);
        }
        catch (\Exception $ex) {
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
        $member_types = MemberType::get([ 'id', 'name' ]);
        $status       = [ [ 'id' => 1, 'name' => 'active' ], [ 'id' => 0, 'name' => 'inactive' ] ];
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
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'mobile'         => 'required|string|max:20',
            'pre_address'    => 'required|string|max:255',
            'per_address'    => 'required|string|max:255',
            'nid'            => 'required|string|max:20',
            'salary'         => 'required',
            'joining_date'   => 'required',
            'resign_date'    => 'nullable',
            'status'         => 'required',
            'member_type_id' => 'required',
            'password'       => 'required|string|max:255',

        ]);
        // dd($validatedData, $employee);
        try {
            DB::beginTransaction();

            $validatedData['branch_id']    = session('branch_id');
            $validatedData['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
            if ($request->resign_date) {
                $validatedData['resign_date'] = date('Y-m-d', strtotime($request->resign_date));
            }
            if ($request->hasfile('image')) {
                $image                  = (new Image)->dirName('employee')->file($request->image)->resizeImage(100, 100)->save();
                $validatedData['image'] = $image;
            }

            $data['name']      = ($request->name);
            $data['email']     = ($request->email);
            $data['mobile']    = ($request->mobile);
            $data['branch_id'] = $validatedData['branch_id'];
            $data['role_type'] = 'employee';
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                $data['image'] = $validatedData['image'];
            }
            $admin = Admin::where('email', $employee->email)->where('mobile', $employee->mobile)->first();
            if ($admin) {
                $admin->update($data);
            }
            else {
                Admin::create($data);
            }
            $employee->update($validatedData);
            DB::commit();
        }
        catch (\Exception $ex) {
            DB::rollBack();
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
            Admin::where('email', $employee->email)->where('name', $employee->name)->where('mobile', $employee->mobile)->delete();
        }
        catch (\Exception $ex) {
            return response()->json([ 'status' => false, 'mes' => 'Something went wrong!This was relationship Data.' ]);
        }
        return response()->json([ 'status' => true, 'mes' => 'Data Deleted Successfully' ]);
    }
}
