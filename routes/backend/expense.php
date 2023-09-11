<?php


use App\Http\Controllers\Expense\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin', 'prefix' =>'admin' , 'as'=>'backend.'], function(){
    Route::resource('expense', ExpenseController::class);
});
