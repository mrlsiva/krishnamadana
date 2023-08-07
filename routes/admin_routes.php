<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Livewire\Admin\CategoryList;
use App\Http\Livewire\Admin\CreateCategory;
use App\Http\Livewire\Admin\CreateProduct;
use App\Http\Livewire\Admin\CreateProductVariation;
use App\Http\Livewire\Admin\CreateUser;
use App\Http\Livewire\Admin\CreateVariationOption;
use App\Http\Livewire\Admin\OrderList;
use App\Http\Livewire\Admin\ProductList;
use App\Http\Livewire\Admin\UserList;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
    Route::view('/login', 'admin.auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', ProductList::class)->name('dashboard');
        Route::prefix('/store')->name('store.')->group(function() {
            Route::get('/variation', CreateProductVariation::class)->name('createProductVariation');
            Route::get('/variation/option', CreateVariationOption::class)->name('createVariationOption');
            Route::get('/product', ProductList::class)->name('productList');
            Route::get('/product/create', CreateProduct::class)->name('createProduct');
            Route::get('/product/{product}/edit', CreateProduct::class)->name('editProduct');
            Route::get('/category', CategoryList::class)->name('categoryList');
            Route::get('/category/create', CreateCategory::class)->name('createCategory');
        });
        Route::prefix('/user')->name('user.')->group(function() {
            Route::get('/list', UserList::class)->name('list');
            Route::get('/create', CreateUser::class)->name('create');
            Route::get('/edit/{user}', CreateUser::class)->name('edit');
        });
        Route::prefix('/order')->name('order.')->group(function() {
            Route::get('/list', OrderList::class)->name('list');
        });
    });
});
