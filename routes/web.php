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
    Route::view('/admin', 'admin.auth.login')->name('login');
    Route::post('/admin', [AdminAuthController::class,'login']);

    Route::view('/admin/register', 'admin.auth.register')->name('register');
    Route::post('/admin/register', [AdminAuthController::class,'register']);
});

Route::middleware('auth')->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('/admin/products', [ProductController::class,'index'])->name('products_list');
    Route::get('/admin/products/add', [ProductController::class,'add'])->name('product_add');
    Route::post('/admin/products/add', [ProductController::class,'store']);
    Route::post('/admin/products/delete/{id}', [ProductController::class,'delete'])->name('product_delete');
    Route::get('/admin/products/edit/{id}', [ProductController::class,'edit'])->name('product_edit');
    Route::post('/admin/products/edit/{id}', [ProductController::class,'update']);

    Route::view('/admin/categories/add', 'admin.categories.add')->name('category_add');
    Route::post('admin/categories/add', [CategoryController::class,'store']);
    Route::get('/admin/categories', [CategoryController::class,'index'])->name('categories_list');
    Route::post("admin/categories/delete/{id}", [CategoryController::class,'delete'])->name('category_delete');
    Route::get("admin/categories/edit/{id}", [CategoryController::class,'edit'])->name('category_edit');
    Route::post("admin/categories/edit/{id}", [CategoryController::class,'update']);

    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
