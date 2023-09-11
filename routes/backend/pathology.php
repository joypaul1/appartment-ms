<?php

use App\Http\Controllers\Backend\Pathology\Expense\ExpenseController;
use App\Http\Controllers\Backend\Pathology\Item\BrandController;
use App\Http\Controllers\Backend\Pathology\Item\CategoryController;
use App\Http\Controllers\Backend\Pathology\Item\ChildCategoryController;
use App\Http\Controllers\Backend\Pathology\Item\GenericNameController;
use App\Http\Controllers\Backend\Pathology\Item\ItemController;
use App\Http\Controllers\Backend\Pathology\Item\RackController;
use App\Http\Controllers\Backend\Pathology\Item\RowController;
use App\Http\Controllers\Backend\Pathology\Item\StrengthController;
use App\Http\Controllers\Backend\Pathology\Item\SubcategoryController;
use App\Http\Controllers\Backend\Pathology\Item\TypeController;
use App\Http\Controllers\Backend\Pathology\Item\UnitController;
use App\Http\Controllers\Backend\Pathology\Purchase\PurchaseController;
use App\Http\Controllers\Backend\Pathology\Report\ReportController;
use App\Http\Controllers\Backend\Pathology\LabTestController;
use App\Http\Controllers\Backend\Pathology\LabTestResultController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin', 'prefix' => 'admin-pathology', 'as' => 'backend.pathology.'], function () {

    Route::get('labTest-moveToMakeReport', [LabTestController::class, 'changeStatus'])->name('labTest.changeStatus');
    Route::get('payment/{id}', [LabTestController::class, 'payment'])->name('payment');
    Route::post('payment-store/{id}', [LabTestController::class, 'paymentStore'])->name('payment.store');
    Route::get('labTest-multiInvoice/{id}', [LabTestController::class, 'multiInvoice'])->name('payment.multiInvoice');
    Route::get('labTest-viewSlot', [LabTestController::class, 'viewSlot'])->name('labTest.viewSlot');
    Route::resource('labTest', LabTestController::class);
    Route::get('make-test-result', [LabTestResultController::class, 'create'])->name('make-test-result');
    Route::POST('make-test-result-store', [LabTestResultController::class, 'store'])->name('make-test-result-store');
    Route::POST('make-test-result-update', [LabTestResultController::class, 'update'])->name('make-test-result-update');
    Route::get('make-test-result-show', [LabTestResultController::class, 'show'])->name('make-test-result-show');
    Route::get('make-test-result-edit', [LabTestResultController::class, 'edit'])->name('make-test-result-edit');
    Route::get('print-cat-result', [LabTestResultController::class, 'printCat'])->name('printCat');
    Route::get('print-test/{labInvoice}', [LabTestResultController::class, 'printTest'])->name('printTest');
    Route::get('print-bar-code/{labInvoice}', [LabTestResultController::class, 'printBarCode'])->name('printBarCode');


    // --------------------------------
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
        Route::resource('import', ItemController::class);

        Route::get('getAjax-itemInfo', [ItemController::class, 'itemInfo'])->name('getAjax.itemInfo');
        Route::get('getPos-itemInfo', [ItemCont\roller::class, 'itemPosInfo'])->name('getPos.itemInfo');
    });


    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'report.'], function () {
        Route::get('day-wise-stock', [ReportController::class, 'dayWiseStock'])->name('dayWiseStock');
        Route::get('sell-report', [ReportController::class, 'sellReport'])->name('sellReport');
        Route::get('stock-report', [ReportController::class, 'stockReport'])->name('stockReport');
        Route::get('stock-summary', [ReportController::class, 'stockSummary'])->name('stockSummary');
        Route::get('stock-alert', [ReportController::class, 'stockAlert'])->name('stockAlert');
        Route::get('expire-report', [ReportController::class, 'expireReport'])->name('expireReport');
        Route::get('purchase-discount-report', [ReportController::class, 'purchaseDiscountReport'])->name('purchaseDiscountReport');
        Route::get('purchase-report', [ReportController::class, 'purchaseReport'])->name('purchaseReport');
        // Route::get('dialysis-report', [ReportController::class, 'dialysisReport'])->name('dialysisReport');

    });
    Route::resource('expense', ExpenseController::class);

});
