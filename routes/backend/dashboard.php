<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\BillDepositController;
use App\Http\Controllers\Backend\BillTypeController;
use App\Http\Controllers\Backend\BuildingController;
use App\Http\Controllers\Backend\ComplainController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\EmployeeSalaryController;
use App\Http\Controllers\Backend\FloorController;
use App\Http\Controllers\Backend\FundController;
use App\Http\Controllers\Backend\Home\DashboardController;
use App\Http\Controllers\Backend\MaintenanceCostController;
use App\Http\Controllers\Backend\ManagementCommitteeController;
use App\Http\Controllers\Backend\MeetingController;
use App\Http\Controllers\Backend\MemberTypeController;
use App\Http\Controllers\Backend\MonthController;
use App\Http\Controllers\Backend\NoticeBoardController;
use App\Http\Controllers\Backend\OwnerController;
use App\Http\Controllers\Backend\OwnerUtilityController;
use App\Http\Controllers\Backend\RentController;
use App\Http\Controllers\Backend\ReportController as BackendReportController;
use App\Http\Controllers\Backend\SiteConfig\EmailConfigurationController;
use App\Http\Controllers\Backend\SiteConfig\SiteInfoController;
use App\Http\Controllers\Backend\TenantController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\VisitorController;
use App\Http\Controllers\Backend\YearController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'backend.'], function () {
    // dashboard
    Route::get('profile', [DashboardController::class, 'profile'])->name('admin.profile');
    Route::post('update-profile', [DashboardController::class, 'profileUpdate'])->name('admin.update-profile');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('branch/{id}', [DashboardController::class, 'branch'])->name('dashboard.branch');
    Route::get('language/{id}', [DashboardController::class, 'language'])->name('dashboard.language');
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

    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('rental-report', [BackendReportController::class, 'rentReport'])->name('rental-report');
        Route::get('tenant-report', [BackendReportController::class, 'tenantReport'])->name('tenant-report');
        Route::get('visitor-report', [BackendReportController::class, 'visitorReport'])->name('visitor-report');
        Route::get('complain-report', [BackendReportController::class, 'complainReport'])->name('complain-report');
        Route::get('unit-report', [BackendReportController::class, 'unitReport'])->name('unit-report');
        Route::get('fund-report', [BackendReportController::class, 'fundReport'])->name('fund-report');
        Route::get('bill-report', [BackendReportController::class, 'billReport'])->name('bill-report');
        Route::get('salary-report', [BackendReportController::class, 'salaryReport'])->name('salary-report');
        Route::get('expense-report', [BackendReportController::class, 'expenseReport'])->name('expense-report');
    });
    Route::group(['prefix' => 'site-config', 'as' => 'site-config.'], function () {
        Route::resource('admin', AdminController::class);
        Route::resource('building', BuildingController::class);
        Route::resource('email', EmailConfigurationController::class);
        Route::resource('system', SiteInfoController::class);
        Route::resource('bill-type', BillTypeController::class);
        Route::resource('member-type', MemberTypeController::class);
        Route::resource('month', MonthController::class);
        Route::resource('year', YearController::class);
    });
});
Route::get('formDesign', [DashboardController::class, 'formDesign']);
Route::get('tableDesign', [DashboardController::class, 'tableDesign']);
