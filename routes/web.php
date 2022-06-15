<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\SalesController as FrontSalesController;
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

Route::get('/', [FrontProductController::class,'index']);
Route::post('/', [FrontSalesController::class,'store']);

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.auth.login')->name('login');
    Route::post('/', [AdminAuthController::class,'login']);

    Route::view('/register', 'admin.auth.register')->name('register');
    Route::post('/register', [AdminAuthController::class,'register']);
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::prefix('categories')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('categories');
        Route::view('/add', 'admin.categories.form')->name('categories.add');
        Route::post('/', 'store')->name('categories.store');
        Route::get("/edit/{category}", 'edit')->name('categories.edit');
        Route::put("/edit/{category}", 'update')->name('categories.update');
        Route::post("/delete/{category}", 'delete')->name('categories.delete');
    });


    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('products');
        Route::get('/add', 'add')->name('products.add');
        Route::post('/', 'store')->name('products.store');
        Route::get('/edit/{product}', 'edit')->name('products.edit');
        Route::put('/edit/{product}', 'update')->name('products.update');
        Route::post('/delete/{product}', 'delete')->name('products.delete');
    });

    Route::prefix('discounts')->controller(DiscountController::class)->group(function () {
        Route::get('/', 'index')->name('discounts');
        Route::get('/add', 'add')->name('discounts.add');
        Route::post('/', 'store')->name('discounts.store');
        Route::get('/edit/{discount}', 'edit')->name('discounts.edit');
        Route::post('/edit/{discount}', 'statusChanged');
        Route::put('/edit/{discount}', 'update')->name('discounts.update');
        Route::post('/delete/{discount}', 'delete')->name('discounts.delete');
    });

    Route::get('/sales', [SalesController::class, 'sales'])->name('sales');
    Route::get('/sales/{id}', [SalesController::class, 'salesDetails'])->name('sales.details');

    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
