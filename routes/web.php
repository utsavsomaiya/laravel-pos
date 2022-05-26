<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;

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

Route::middleware('guest')->group(function () {
    Route::view('/admin', 'admin.auth.login')->name('login');
    Route::post('/admin', [AdminAuthController::class,'login']);

    Route::view('/admin/register', 'admin.auth.register')->name('register');
    Route::post('/admin/register', [AdminAuthController::class,'register']);
});

Route::middleware('auth')->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('dashboard');
    
    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
