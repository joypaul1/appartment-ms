<?php

use App\Http\Controllers\Backend\Home\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'admin', 'prefix' =>'admin' , 'as'=>'backend.'], function(){
        // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // user

    Route::get('formDesign', [DashboardController::class, 'formDesign']);
    Route::get('tableDesign', [DashboardController::class, 'tableDesign']);

});
