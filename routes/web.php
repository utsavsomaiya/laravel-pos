<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\SalesController as FrontSalesController;

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

Route::get('/', [FrontProductController::class,'index']);
Route::post('/', [FrontSalesController::class,'store']);

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::view('/', 'admin.auth.login')->name('login');
        Route::post('/', [AdminAuthController::class,'login']);

        Route::view('/register', 'admin.auth.register')->name('register');
        Route::post('/register', [AdminAuthController::class,'register']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('categories');
            Route::get('/categories/add', 'add')->name('categories.add');
            Route::post('/categories', 'store')->name('categories.store');
            Route::get("/categories/edit/{category}", 'edit')->name('categories.edit');
            Route::put("/categories/edit/{category}", 'update');
            Route::post("/categories/delete/{category}", 'delete')->name('categories.delete');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index')->name('products');
            Route::get('/products/add', 'add')->name('products.add');
            Route::post('/products', 'store')->name('products.store');
            Route::get('/products/edit/{product}', 'edit')->name('products.edit');
            Route::put('/products/edit/{product}', 'update');
            Route::post('/products/delete/{product}', 'delete')->name('products.delete');
        });

        Route::controller(DiscountController::class)->group(function () {
            Route::get('/discounts', 'index')->name('discounts');
            Route::get('/discounts/add', 'add')->name('discounts.add');
            Route::post('/discounts', 'store')->name('discounts.store');
            Route::get('/discounts/edit/{discount}', 'edit')->name('discounts.edit');
            Route::post('/discounts/edit/{discount}', 'statusChanged');
            Route::put('/discounts/edit/{discount}', 'update');
            Route::post('/discounts/delete/{discount}', 'delete')->name('discounts.delete');
        });

        Route::controller(SalesController::class)->group(function () {
            Route::get('/sales', 'sales')->name('sales');
            Route::get('/sales/{id}', 'salesDetails')->name('sales.details');
        });

        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
