<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\NoticeBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticeBoards = NoticeBoard::where('branch_id', session('branch_id'))->get();
        if (auth('admin')->user()->role_type == 'owner') {
            $noticeBoards = NoticeBoard::where('branch_id', session('branch_id'))->get();
            return view('backend.noticeBoard.owner', compact('noticeBoards'));
        }
        return view('backend.noticeBoard.index', compact('noticeBoards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.noticeBoard.create');
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
            'title'    => 'required|string',
            'end_date' => 'required',
            'status'   => 'required',
        ]);
        try {
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['end_date']  = date('Y-m-d', strtotime($request->end_date));

            NoticeBoard::create($validatedData);
        }
        catch (\Exception $ex) {

            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.notice-board.index')->with('success', 'NoticeBoard Created successfully.');
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
    public function edit(NoticeBoard $noticeBoard)
    {
        return view('backend.noticeBoard.edit', compact('noticeBoard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoticeBoard $noticeBoard)
    {
        $validatedData = $request->validate([
            'title'    => 'required|string',
            'end_date' => 'required',
            'status'   => 'required',
        ]);
        try {
            $validatedData['branch_id'] = session('branch_id');
            $validatedData['end_date']  = date('Y-m-d', strtotime($request->end_date));
            $noticeBoard->update($validatedData);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        return redirect()->route('backend.notice-board.index')->with('success', 'NoticeBoard Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoticeBoard $noticeBoard)
    {
        try {
            DB::beginTransaction();
            $noticeBoard->delete();
            DB::commit();
        }
        catch (\Exception $ex) {
            DB::rollback();
            return response()->json([ 'status' => false, 'mes' => 'Something went wrong!' ]);
        }
        return response()->json([ 'status' => true, 'mes' => 'Data Deleted Successfully' ]);
    }
}
