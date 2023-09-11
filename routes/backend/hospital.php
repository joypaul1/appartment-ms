<?php

use App\Http\Controllers\Backend\Appointment\DialysisAppointmentController;
use App\Http\Controllers\Backend\HospitalInventory\Item\BrandController;
use App\Http\Controllers\Backend\HospitalInventory\Item\CategoryController;
use App\Http\Controllers\Backend\HospitalInventory\Item\ChildCategoryController;;

use App\Http\Controllers\Backend\HospitalInventory\Item\GenericNameController;
use App\Http\Controllers\Backend\HospitalInventory\Item\ItemController;
use App\Http\Controllers\Backend\HospitalInventory\Item\RackController;
use App\Http\Controllers\Backend\HospitalInventory\Item\RowController;
use App\Http\Controllers\Backend\HospitalInventory\Item\TypeController;
use App\Http\Controllers\Backend\HospitalInventory\Item\StrengthController;
use App\Http\Controllers\Backend\HospitalInventory\Item\SubcategoryController;
use App\Http\Controllers\Backend\HospitalInventory\Item\UnitController;
use App\Http\Controllers\Backend\HospitalInventory\Report\ReportController;
use App\Http\Controllers\Backend\HospitalInventory\Purchase\PurchaseController;
use App\Http\Controllers\Backend\HospitalInventory\Item\ImportController;
use Illuminate\Support\Facades\Route;



// dailyses appointment
Route::group(['middleware' => 'admin', 'prefix' => 'admin-hospital-inventory', 'as' => 'backend.hospital_inventory.'], function () {
    Route::resource('appointment', DialysisAppointmentController::class);

    // purchase
    Route::resource('purchase', PurchaseController::class);
    // category
    Route::group(['as' => 'itemConfig.'], function () {
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

        //import item
        Route::get('item-import', [ImportController::class, 'importView'])->name('itemImport');
        Route::post('item-import-store', [ImportController::class, 'import'])->name('itemImportStore');

        Route::get('getAjax-itemInfo', [ItemController::class, 'itemInfo'])->name('getAjax.itemInfo');
        Route::get('getPos-itemInfo', [ItemController::class, 'itemPosInfo'])->name('getPos.itemInfo');
    });



    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'report.'], function () {
        Route::get('day-wise-stock', [ReportController::class, 'dayWiseStock'])->name('dayWiseStock');
        Route::get('sell-report', [ReportController::class, 'sellReport'])->name('sellReport');
        Route::get('stock-report', [ReportController::class, 'stockReport'])->name('stockReport');
        Route::get('stock-summary', [ReportController::class, 'stockSummary'])->name('stockSummary');
        Route::get('stock-alert', [ReportController::class, 'stockAlert'])->name('stockAlert');
        Route::get('expire-report', [ReportController::class, 'expireReport'])->name('expireReport');
        Route::get('purchase-report', [ReportController::class, 'purchaseReport'])->name('purchaseReport');
        Route::get('purchase-discount-report', [ReportController::class, 'purchaseDiscountReport'])->name('purchaseDiscountReport');
        Route::get('dialysis-report', [ReportController::class, 'dialysisReport'])->name('dialysisReport');
    });
    Route::resource('expense', ExpenseController::class);

});
