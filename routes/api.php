<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Public\Auth\AuthController;

use App\Http\Controllers\API\Public\ProductsController;
use App\Http\Controllers\API\Public\CategoriesController;
use App\Http\Controllers\API\Public\OrderController;
use App\Http\Controllers\API\Public\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* ================== PUBLIC API Routes ================== */
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');    
});

Route::middleware('auth:api')->group(function () {    
    Route::get('/account', [AuthController::class, 'myAccount'])->name('myAccount');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/address/save', [AuthController::class, 'saveAddress'])->name('saveAddress');
    Route::get('/address/delete/{id}', [AuthController::class, 'deleteAddress'])->name('deleteAddress');
    //Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
   // Route::get('/order-confirmation', [OrderController::class, 'receiveConfirmation'])->name('receive-confirmation');
       
});

Route::get('/products', [ProductsController::class, 'getAllProducts'])->name('get-all-products');
Route::get('/product/{slug}', [ProductsController::class, 'productDetails'])->name('product-details');
Route::get('/collections/{slug}', [CategoriesController::class, 'collections'])->name('collections');
Route::get('/cart/{slug}', [CartController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('/cart/remove/{id}', [CartController::class, 'remove_from_cart'])->name('remove_from_cart');
Route::get('/cart/quantity/plus/{id}', [CartController::class, 'increase_quantity'])->name('increase_quantity');
Route::get('/cart/quantity/minus/{id}', [CartController::class, 'reduce_quantity'])->name('reduce_quantity');


/* ================== ADMIN API Routes ================== */
Route::name('admin.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', ProductList::class)->name('dashboard');        
    });
});