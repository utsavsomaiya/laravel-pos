<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;

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


    Route::view('/admin/categories/add', 'admin.categories.add')->name('categories.add');
    Route::post('admin/categories/add', [CategoryController::class,'store']);
    Route::get('/admin/categories', [CategoryController::class,'index'])->name('categories');
    Route::post("admin/categories/delete/{id}", [CategoryController::class,'delete'])->name('categories.delete');
    Route::get("admin/categories/edit/{id}", [CategoryController::class,'edit'])->name('categories.edit');
    Route::post("admin/categories/edit/{id}", [CategoryController::class,'update']);

    Route::get('/admin/products', [ProductController::class,'index'])->name('products');
    Route::get('/admin/products/add', [ProductController::class,'add'])->name('products.add');
    Route::post('/admin/products/add', [ProductController::class,'store']);
    Route::post('/admin/products/delete/{id}', [ProductController::class,'delete'])->name('products.delete');
    Route::get('/admin/products/edit/{id}', [ProductController::class,'edit'])->name('products.edit');
    Route::post('/admin/products/edit/{id}', [ProductController::class,'update']);

    Route::get('/admin/discounts', [DiscountController::class,'index'])->name('discounts');
    Route::post('/admin/discounts', [DiscountController::class,'statusChanged']);
    Route::get('/admin/discounts/add', [DiscountController::class,'add'])->name('discounts.add');
    Route::post('/admin/discounts/add', [DiscountController::class,'store']);
    Route::post('/admin/discounts/delete/{id}', [DiscountController::class,'delete'])->name('discounts.delete');
    Route::get('/admin/discounts/edit/{id}', [DiscountController::class,'edit'])->name('discounts.edit');
    Route::post('/admin/discounts/edit/{id}', [DiscountController::class,'update']);

    Route::get('/admin/sales', [SalesController::class, 'sales'])->name('sales');
    Route::get('/admin/sales/{id}', [SalesController::class, 'salesDetails'])->name('sales.details');

    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
