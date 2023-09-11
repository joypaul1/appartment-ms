<?php

use App\Http\Controllers\Backend\Appointment\DialysisAppointmentController;
use App\Http\Controllers\Backend\Dialysis\Expense\ExpenseController;
use App\Http\Controllers\Backend\Dialysis\Item\BrandController;
use App\Http\Controllers\Backend\Dialysis\Item\CategoryController;
use App\Http\Controllers\Backend\Dialysis\Item\ChildCategoryController;;

use App\Http\Controllers\Backend\Dialysis\Item\GenericNameController;
use App\Http\Controllers\Backend\Dialysis\Item\ImportController;
use App\Http\Controllers\Backend\Dialysis\Item\ItemController;
use App\Http\Controllers\Backend\Dialysis\Item\RackController;
use App\Http\Controllers\Backend\Dialysis\Item\RowController;
use App\Http\Controllers\Backend\Dialysis\Item\TypeController;
use App\Http\Controllers\Backend\Dialysis\Item\StrengthController;
use App\Http\Controllers\Backend\Dialysis\Item\SubcategoryController;
use App\Http\Controllers\Backend\Dialysis\Item\UnitController;
use App\Http\Controllers\Backend\Dialysis\Order\DeliveredController;
use App\Http\Controllers\Backend\Dialysis\Order\OrderController;
use App\Http\Controllers\Backend\Dialysis\Order\PendingController;
use App\Http\Controllers\Backend\Dialysis\Order\ProcessingController;
use App\Http\Controllers\Backend\Dialysis\Report\ReportController;
use App\Http\Controllers\Backend\Dialysis\Purchase\PurchaseController;
use Illuminate\Support\Facades\Route;



// dailyses appointment
Route::group(['middleware' => 'admin', 'prefix' => 'admin-dialysis', 'as' => 'backend.dialysis.'], function () {
    Route::resource('appointment', DialysisAppointmentController::class);

    // purchase
    Route::resource('purchase', PurchaseController::class);

    // itemConfig
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


    // order-list
    Route::group(['as' => 'order.'], function () {
        Route::resource('order-list-pending', PendingController::class);
        Route::resource('order-list-processing', ProcessingController::class);
        Route::resource('order-list-delivered', DeliveredController::class);
        Route::resource('order-list', OrderController::class);
    });
    Route::resource('expense', ExpenseController::class);

});
