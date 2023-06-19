<?php

use App\Http\Livewire\Public\Category\ListCategoryProducts;
use App\Http\Livewire\Public\Product\ProductDetails;
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

Route::prefix('admin')->group(base_path('routes/admin_routes.php'));

Route::view('/', 'public.home')->name('home');
Route::name('home.')->group(function () {
    Route::get('/product/{slug}', ProductDetails::class)->name('product-details');
    Route::get('/collections/{collection}', ListCategoryProducts::class)->name('collections');
});
