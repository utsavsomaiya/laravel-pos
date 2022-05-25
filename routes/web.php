<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

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
    Route::get('/admin', function () {
        return view('admin.auth.login');
    })->name('login');
    Route::get('/admin/register', function () {
        return view('admin.auth.register');
    });
    Route::post('/admin', [AdminAuthController::class,'login']);
    Route::post('/admin/register', [AdminAuthController::class,'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/logout', [AdminAuthController::class, 'logout']);

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/products', [ProductController::class,'show']);
    Route::get('/admin/products/add', [ProductController::class,'add']);
    Route::post('/admin/products/add', [ProductController::class,'store']);
    Route::get('/admin/products/delete/{id}', [ProductController::class,'delete']);
    Route::get('/admin/products/edit/{id}', [ProductController::class,'edit']);
    Route::post('/admin/products/edit/{id}', [ProductController::class,'update']);

    Route::get('/admin/categories/add', function () {
        return view('admin.categories.add');
    });
    Route::post('admin/categories/add', [CategoryController::class,'store']);
    Route::get('/admin/categories', [CategoryController::class,'show']);
    Route::get("admin/categories/delete/{id}", [CategoryController::class,'delete']);
    Route::get("admin/categories/edit/{id}", [CategoryController::class,'edit']);
    Route::post("admin/categories/edit/{id}", [CategoryController::class,'update']);
});
