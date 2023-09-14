<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Backend\Employee;
use App\Models\Backend\EmployeeSalary;
use App\Models\Backend\MemberType;
use App\Models\Backend\Year;
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
        $data = EmployeeSalary::where('branch_id', auth('admin')->user()->branch_id)->with('employee:id,name', 'year:id,name', 'month:id,name')->get();
        return view('backend.employee_salary.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::get(['id', 'name']);
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id' => $i,
                'name' => $date->format('F')
            ];
        }
        $years = Year::get(['id', 'name']);
        return view('backend.employee_salary.create', compact('employees', 'years', 'months'));
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
            'salary'        => 'required',
            'issue_date'    => 'required',
            'employee_id'   => 'required',
            'month_id'      => 'required',
            'year_id'       => 'required',
        ]);
        try {
            $validatedData['amount'] = $request->salary;
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['issue_date'] = date('Y-m-d', strtotime($request->issue_date));

            EmployeeSalary::create($validatedData);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.employee-salary.index')->with('success', 'Employee Salary Created successfully.');
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
    public function edit(EmployeeSalary $employeeSalary)
    {
        $employees = Employee::get(['id', 'name']);
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'id' => $i,
                'name' => $date->format('F')
            ];
        }
        $years = Year::get(['id', 'name']);
        return view('backend.employee_salary.edit', compact('employees', 'years', 'months', 'employeeSalary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        $validatedData = $request->validate([
            'salary'        => 'required',
            'issue_date'    => 'required',
            'employee_id'   => 'required',
            'month_id'      => 'required',
            'year_id'       => 'required',
        ]);
        try {
            $validatedData['amount'] = $request->salary;
            $validatedData['branch_id'] = auth('admin')->user()->branch_id;
            $validatedData['issue_date'] = date('Y-m-d', strtotime($request->issue_date));

            $employeeSalary->update($validatedData);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error',  $ex->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('backend.employee-salary.index')->with('success', 'Employee Salary Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        try {
            $employeeSalary->delete();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'mes' => 'Something went wrong!This was relationship Data.']);
        }
        // (new LogActivity)::addToLog('Category Deleted');
        return  response()->json(['status' => true, 'mes' => 'Data Deleted Successfully']);
    }
}
