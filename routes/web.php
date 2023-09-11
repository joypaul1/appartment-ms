<?php

use App\Http\Controllers\Auth\Backend\LoginController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[LoginController::class, 'showLoginForm'])->name('home');
Route::get('/file-import',[ImportController::class,'importView'])->name('import-view');
Route::post('/import',[ImportController::class,'import'])->name('import');
Route::get('/export-users',[ImportController::class,'exportUsers'])->name('export-users');

