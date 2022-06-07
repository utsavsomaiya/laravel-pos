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

        Route::prefix('categories')->group(function () {
            Route::controller(CategoryController::class)->group(function () {
                Route::get('/', 'index')->name('categories');
                Route::get('/add', 'add')->name('categories.add');
                Route::post('/', 'store')->name('categories.store');
                Route::get("/edit/{category}", 'edit')->name('categories.edit');
                Route::put("/edit/{category}", 'update')->name('categories.update');
                Route::post("/delete/{category}", 'delete')->name('categories.delete');
            });
        });

        Route::prefix('products')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                Route::get('/', 'index')->name('products');
                Route::get('/add', 'add')->name('products.add');
                Route::post('/', 'store')->name('products.store');
                Route::get('/edit/{product}', 'edit')->name('products.edit');
                Route::put('/edit/{product}', 'update');
                Route::post('/delete/{product}', 'delete')->name('products.delete');
            });
        });

        Route::prefix('discounts')->group(function () {
            Route::controller(DiscountController::class)->group(function () {
                Route::get('/', 'index')->name('discounts');
                Route::get('/add', 'add')->name('discounts.add');
                Route::post('/', 'store')->name('discounts.store');
                Route::get('/edit/{discount}', 'edit')->name('discounts.edit');
                Route::post('/edit/{discount}', 'statusChanged');
                Route::put('/edit/{discount}', 'update')->name('discounts.update');
                Route::post('/delete/{discount}', 'delete')->name('discounts.delete');
            });
        });

        Route::prefix('sales')->group(function () {
            Route::controller(SalesController::class)->group(function () {
                Route::get('/', 'sales')->name('sales');
                Route::get('/{id}', 'salesDetails')->name('sales.details');
            });
        });

        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
