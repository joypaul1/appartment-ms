<?php


use App\Http\Controllers\Backend\Contact\SupplierController;
use App\Http\Controllers\Backend\Report\ReportController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'backend.report.'], function () {

    Route::get('supplier-ledger', [SupplierController::class, 'ledgerReport'])->name('supplierledgerReport');
    Route::get('day-book', [ReportController::class, 'dayBook'])->name('dayBook');
    Route::get('cash-flow', [ReportController::class, 'cashFlow'])->name('cashFlow');
    Route::get('day-wise-stock', [ReportController::class, 'dayWiseStock'])->name('dayWiseStock');
    Route::get('sell-report', [ReportController::class, 'sellReport'])->name('sellReport');
    Route::get('stock-report', [ReportController::class, 'stockReport'])->name('stockReport');
    Route::get('stock-summary', [ReportController::class, 'stockSummary'])->name('stockSummary');
    Route::get('stock-alert', [ReportController::class, 'stockAlert'])->name('stockAlert');
    Route::get('expire-report', [ReportController::class, 'expireReport'])->name('expireReport');
    Route::get('purchase-report', [ReportController::class, 'purchaseReport'])->name('purchaseReport');
    Route::get('appointment-doc-wise-report', [ReportController::class, 'appointmentDocWiseReport'])->name('appointmentDocWiseReport');
    Route::get('appointment-report', [ReportController::class, 'appointmentReport'])->name('appointmentReport');
    Route::get('dialysis-report', [ReportController::class, 'dialysisReport'])->name('dialysisReport');
    Route::get('radiology-report', [ReportController::class, 'radiologyReport'])->name('radiologyReport');
    Route::get('pathology-report', [ReportController::class, 'pathologyReport'])->name('pathologyReport');
    Route::get('income-report', [ReportController::class, 'incomeReport'])->name('incomeReport');
    Route::get('expense-report', [ReportController::class, 'expenseReport'])->name('expenseReport');
    Route::get('profit-report', [ReportController::class, 'profitReport'])->name('profitReport');
    Route::get('doctor-wise-patient-visit', [ReportController::class, 'patientVisit'])->name('doctorWisePatientVisit');
});
