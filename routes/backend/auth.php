<?php

use App\Http\Controllers\Auth\Backend\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('admin-login', [LoginController::class, 'showLoginForm'])->name('backend.login.form');
Route::Post('admin-login', [LoginController::class, 'login'])->name('backend.admin.login');
Route::Post('admin-logout', [LoginController::class, 'logout'])->name('backend.admin.logout');

require_once __DIR__ . '/dashboard.php';
