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

    Route::get('/admin/categories', [CategoryController::class,'index'])->name('categories');
    Route::view('/admin/categories/add', 'admin.categories.add')->name('categories.add');
    Route::post('admin/categories', [CategoryController::class,'store'])->name('categories.store');
    Route::get("admin/categories/edit/{category}", [CategoryController::class,'edit'])->name('categories.edit');
    Route::put("admin/categories/edit/{category}", [CategoryController::class,'update']);
    Route::post("admin/categories/delete/{category}", [CategoryController::class,'delete'])->name('categories.delete');


    Route::get('/admin/products', [ProductController::class,'index'])->name('products');
    Route::get('/admin/products/add', [ProductController::class,'add'])->name('products.add');
    Route::post('/admin/products', [ProductController::class,'store'])->name('products.store');
    Route::get('/admin/products/edit/{product}', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/admin/products/edit/{product}', [ProductController::class,'update']);
    Route::post('/admin/products/delete/{product}', [ProductController::class,'delete'])->name('products.delete');

    Route::get('/admin/discounts', [DiscountController::class,'index'])->name('discounts');
    Route::get('/admin/discounts/add', [DiscountController::class,'add'])->name('discounts.add');
    Route::post('admin/discounts', [DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/admin/discounts/edit/{discount}', [DiscountController::class,'edit'])->name('discounts.edit');
    Route::post('/admin/discounts/edit/{discount}', [DiscountController::class,'statusChanged']);
    Route::put('/admin/discounts/edit/{discount}', [DiscountController::class,'update']);
    Route::post('/admin/discounts/delete/{discount}', [DiscountController::class,'delete'])->name('discounts.delete');

    Route::get('/admin/sales', [SalesController::class, 'sales'])->name('sales');
    Route::get('/admin/sales/{id}', [SalesController::class, 'salesDetails'])->name('sales.details');

    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
