<?php

use App\Http\Controllers\Backend\Item\BrandController;
use App\Http\Controllers\Backend\Item\CategoryController;
use App\Http\Controllers\Backend\Item\ChildCategoryController;
use App\Http\Controllers\Backend\Item\ColorController;
use App\Http\Controllers\Backend\Item\GenericNameController;
use App\Http\Controllers\Backend\Item\ItemController;
use App\Http\Controllers\Backend\Item\RackController;
use App\Http\Controllers\Backend\Item\RowController;
use App\Http\Controllers\Backend\Item\TypeController;
use App\Http\Controllers\Backend\Item\StrengthController;
use App\Http\Controllers\Backend\Item\SubcategoryController;
use App\Http\Controllers\Backend\Item\UnitController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'admin', 'prefix' =>'admin/item-config' , 'as'=>'backend.itemConfig.'], function(){

    // category
    Route::resource('category', CategoryController::class);
    // subcategory
    Route::get('subcategory/ajaxData', [SubcategoryController::class, 'ajaxData'])->name('subcategory.ajaxData');
    Route::resource('subcategory', SubcategoryController::class);
    // ChildCategory
    Route::resource('childCategory', ChildCategoryController::class);
    // manufacturer
    Route::resource('generic-name', GenericNameController::class);
     // brand
    Route::resource('brand', BrandController::class);
        // color
    Route::resource('color', ColorController::class);
        // type
    Route::resource('type', TypeController::class);
        // unit
    Route::resource('unit', UnitController::class);
        // rack
    Route::resource('rack', RackController::class);
        // row
    Route::resource('row', RowController::class);
        // strength
    Route::resource('strength', StrengthController::class);
        // item
    Route::resource('item', ItemController::class);
    Route::resource('import', ItemController::class);

    Route::get('getAjax-itemInfo', [ItemController::class, 'itemInfo'])->name('getAjax.itemInfo');
    Route::get('getPos-itemInfo', [ItemController::class, 'itemPosInfo'])->name('getPos.itemInfo');
});
