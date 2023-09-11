<?php

namespace App\Http\Controllers\Backend\Pathology\Item;


use App\Helpers\Image;
use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChildCategory\StoreRequest;
use App\Http\Requests\ChildCategory\UpdateRequest;
use App\Models\Item\Category;
use App\Models\Item\ChildCategory;
use App\Models\Item\Subcategory;
use Illuminate\Http\Request;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $childcategories = ChildCategory::where('category_id',4)->select('id', 'name', 'slug', 'image', 'status', 'category_id', 'subcategory_id');

        if($request->subcategory_id) {
            $childcategories  =  $childcategories->where('subcategory_id', $request->subcategory_id);
            return response()->json(['data' => $childcategories->select('id', 'name')->get()]);
        }
        $childcategories = $childcategories->paginate(10);
        return view('backend.pathology.item.childcategory.index', compact('childcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pathology.item.childcategory.create',  ['subcategories' => Subcategory::where('category_id',4)->get(['id', 'name'])]);
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
        if($returnData->getData()->status){
            (new LogActivity)::addToLog('ChildCategory Created');
            return back()->with(['success' => $returnData->getData()->msg  ]);
        }

        return back()->with(['error' =>$returnData->getData()->msg ]);

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
    public function edit(ChildCategory $childCategory)
    {
        return view('backend.pathology.item.childcategory.edit',['categories' => Category::get(['id', 'name']),
         'subcategories'=>  Subcategory::where('category_id', $childCategory->category_id)->get(['id', 'name'])],compact('childcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, ChildCategory $childCategory)
    {
         $returnData = $request->updateData($request, $childCategory);
        if($returnData->getData()->status){
            return back()->with(['success' => $returnData->getData()->msg  ]);
        }
        (new LogActivity)::addToLog('ChildCategory Updated');

        return back()->with(['error' =>$returnData->getData()->msg ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChildCategory $childCategory)
    {
        try {
            (new Image)->deleteIfExists($childCategory->image);
            $childCategory->delete();
        } catch (\Exception $ex) {
            return back()->with(['status' => false, 'error' =>$ex->getMessage()]);
        }
        (new LogActivity)::addToLog('ChildCategory Delete');
        return back()->with(['status' => true, 'success' => 'Data Deleted Successfully']);
    }
}
