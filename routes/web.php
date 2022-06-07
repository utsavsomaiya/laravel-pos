<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
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
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        Route::get('/categories', [CategoryController::class,'index'])->name('categories');
        Route::view('/categories/add', 'admin.categories.form')->name('categories.add');
        Route::post('/categories', [CategoryController::class,'store'])->name('categories.store');
        Route::get("/categories/edit/{category}", [CategoryController::class,'edit'])->name('categories.edit');
        Route::put("/categories/edit/{category}", [CategoryController::class,'update'])->name('categories.update');
        Route::post("/categories/delete/{category}", [CategoryController::class,'delete'])->name('categories.delete');


        Route::get('/products', [ProductController::class,'index'])->name('products');
        Route::get('/products/add', [ProductController::class,'add'])->name('products.add');
        Route::post('/products', [ProductController::class,'store'])->name('products.store');
        Route::get('/products/edit/{product}', [ProductController::class,'edit'])->name('products.edit');
        Route::put('/products/edit/{product}', [ProductController::class,'update'])->name('products.update');
        Route::post('/products/delete/{product}', [ProductController::class,'delete'])->name('products.delete');

        Route::get('/discounts', [DiscountController::class,'index'])->name('discounts');
        Route::get('/discounts/add', [DiscountController::class,'add'])->name('discounts.add');
        Route::post('/discounts', [DiscountController::class, 'store'])->name('discounts.store');
        Route::get('/discounts/edit/{discount}', [DiscountController::class,'edit'])->name('discounts.edit');
        Route::post('/discounts/edit/{discount}', [DiscountController::class,'statusChanged'])->name('discounts.update');
        Route::put('/discounts/edit/{discount}', [DiscountController::class,'update']);
        Route::post('/discounts/delete/{discount}', [DiscountController::class,'delete'])->name('discounts.delete');

        Route::get('/sales', [SalesController::class, 'sales'])->name('sales');
        Route::get('/sales/{id}', [SalesController::class, 'salesDetails'])->name('sales.details');

        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
