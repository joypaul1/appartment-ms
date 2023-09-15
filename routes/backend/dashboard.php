<?php

use App\Http\Controllers\Backend\BillDepositController;
use App\Http\Controllers\Backend\ComplainController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\EmployeeSalaryController;
use App\Http\Controllers\Backend\FloorController;
use App\Http\Controllers\Backend\FundController;
use App\Http\Controllers\Backend\Home\DashboardController;
use App\Http\Controllers\Backend\MaintenanceCostController;
use App\Http\Controllers\Backend\ManagementCommitteeController;
use App\Http\Controllers\Backend\MeetingController;
use App\Http\Controllers\Backend\NoticeBoardController;
use App\Http\Controllers\Backend\OwnerController;
use App\Http\Controllers\Backend\OwnerUtilityController;
use App\Http\Controllers\Backend\RentController;
use App\Http\Controllers\Backend\ReportController as BackendReportController;
use App\Http\Controllers\Backend\TenantController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\VisitorController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'backend.'], function () {
    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // user
    Route::resource('floor', FloorController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('owner', OwnerController::class);
    Route::resource('tenant', TenantController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('employee-salary', EmployeeSalaryController::class);
    Route::resource('employee-leave', EmployeeSalaryController::class);
    Route::resource('rent', RentController::class);
    Route::resource('owner-utility', OwnerUtilityController::class);
    Route::resource('maintenance-cost', MaintenanceCostController::class);
    Route::resource('management-committee', ManagementCommitteeController::class);
    Route::resource('fund', FundController::class);
    Route::resource('bill-deposit', BillDepositController::class);
    Route::resource('complain', ComplainController::class);
    Route::resource('visitor', VisitorController::class);
    Route::resource('meeting', MeetingController::class);
    Route::resource('notice-board', NoticeBoardController::class);
    Route::get('rental-report', [BackendReportController::class, 'rentReport']);
    Route::get('tenant-report', [BackendReportController::class, 'tenantReport']);
    Route::get('visitor-report', [BackendReportController::class, 'visitorReport']);
    Route::get('complain-report', [BackendReportController::class, 'complainReport']);
    Route::get('unit-report', [BackendReportController::class, 'unitReport']);
    Route::get('fund-report', [BackendReportController::class, 'fundReport']);
    Route::get('bill-report', [BackendReportController::class, 'billReport']);
    Route::get('salary-report', [BackendReportController::class, 'salaryReport']);


    Route::get('formDesign', [DashboardController::class, 'formDesign']);
    Route::get('tableDesign', [DashboardController::class, 'tableDesign']);
});
