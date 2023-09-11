<?php

use App\Http\Controllers\Backend\Pharmacy\Expense\ExpenseController;
use App\Http\Controllers\Backend\Pharmacy\Order\DeliveredController;
use App\Http\Controllers\Backend\Pharmacy\Order\PendingController;
use App\Http\Controllers\Backend\Pharmacy\Order\ProcessingController;
use App\Http\Controllers\Backend\Pharmacy\Order\OrderController;
use App\Http\Controllers\Backend\Pharmacy\Purchase\PurchaseController;
use App\Http\Controllers\Backend\Pharmacy\Item\BrandController;
use App\Http\Controllers\Backend\Pharmacy\Item\CategoryController;
use App\Http\Controllers\Backend\Pharmacy\Item\ChildCategoryController;
use App\Http\Controllers\Backend\Pharmacy\Item\GenericNameController;
use App\Http\Controllers\Backend\Pharmacy\Item\ImportController;
use App\Http\Controllers\Backend\Pharmacy\Item\ItemController;
use App\Http\Controllers\Backend\Pharmacy\Item\RackController;
use App\Http\Controllers\Backend\Pharmacy\Item\RowController;
use App\Http\Controllers\Backend\Pharmacy\Item\TypeController;
use App\Http\Controllers\Backend\Pharmacy\Item\StrengthController;
use App\Http\Controllers\Backend\Pharmacy\Item\SubcategoryController;
use App\Http\Controllers\Backend\Pharmacy\Item\UnitController;
use App\Http\Controllers\Backend\Pharmacy\Report\ReportController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'admin', 'prefix' => 'admin-pharmacy', 'as' => 'backend.pharmacy.'], function () {
    // purchase
    Route::resource('purchase', PurchaseController::class);

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

    Route::group(['as' => 'report.'], function () {
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
