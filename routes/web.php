<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
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

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.auth.login')->name('login');
    Route::post('/', [AdminAuthController::class,'login']);

    Route::view('/register', 'admin.auth.register')->name('register');
    Route::post('/register', [AdminAuthController::class,'register']);
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::prefix('categories')
        ->controller(CategoryController::class)
        ->name('categories.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::view('/add', 'admin.categories.form')->name('add');
            Route::post('/', 'store')->name('store');
            Route::get("/edit/{category}", 'edit')->name('edit');
            Route::put("/edit/{category}", 'update')->name('update');
            Route::post("/delete/{category}", 'delete')->name('delete');
        });


    Route::prefix('products')
        ->controller(ProductController::class)
        ->name('products.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'add')->name('add');
            Route::post('/', 'store')->name('store');
            Route::get('/edit/{product}', 'edit')->name('edit');
            Route::put('/edit/{product}', 'update')->name('update');
            Route::post('/delete/{product}', 'delete')->name('delete');
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

    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
