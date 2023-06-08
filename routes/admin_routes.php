<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Livewire\Admin\CategoryList;
use App\Http\Livewire\Admin\CreateCategory;
use App\Http\Livewire\Admin\CreateProduct;
use App\Http\Livewire\Admin\ProductList;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
    Route::view('/login', 'admin.auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', ProductList::class)->name('dashboard');
        Route::get('/product', ProductList::class)->name('productList');
        Route::get('/product/create', CreateProduct::class)->name('createProduct');
        Route::get('/product/{product}/edit', CreateProduct::class)->name('editProduct');
        Route::get('/category', CategoryList::class)->name('categoryList');
        Route::get('/category/create', CreateCategory::class)->name('createCategory');
    });
});
