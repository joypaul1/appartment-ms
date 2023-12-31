<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\Image;
use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\LogActivity as BackendLogActivity;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth('admin')->user()->role_type == 'super_admin'){
            $admins = Admin::where('role_type', 'super_admin')->paginate(10);
            return view('backend.admin.index', compact('admins'));
        }
        return redirect()->to('admin/dashboard');
    }

    public function logIndex()
    {
        $activities = BackendLogActivity::with('admin')->paginate(50);
        return view('backend.admin.logIndex', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(auth('admin')->user()->role_type == 'super_admin'){
            $branches = Branch::get(['id', 'name']);
            return view('backend.admin.create', compact('branches'));
        }
        return redirect()->to('admin/dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $returnData = $request->storeData($request);
        if ($returnData->getData()->status) {

            return back()->with(['success' => $returnData->getData()->msg]);
        }
        return back()->with(['error' => $returnData->getData()->msg]);
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
    public function edit(Admin $admin)
    {

        return view('backend.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Admin $admin)
    {

        $returnData = $request->updateData($request, $admin);
        if ($returnData->getData()->status) {
            return back()->with(['success' => $returnData->getData()->msg]);
        }
        return back()->with(['error' => $returnData->getData()->msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        try {
            (new Image)->deleteIfExists($admin->image);
            $admin->delete();
        } catch (\Exception $ex) {
            return back()->with(['status' => false, 'error' => $ex->getMessage()]);
        }
        (new LogActivity)::addToLog('Admin Deleted');

        return back()->with(['status' => true, 'success' => 'Data Deleted Successfully']);
    }
}
