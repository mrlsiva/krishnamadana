<?php

use App\Http\Controllers\OrderConfirmationController;
use App\Http\Livewire\Public\Account\ManageAddresses;
use App\Http\Livewire\Public\Account\UserAccount;
use App\Http\Livewire\Public\Auth\Login;
use App\Http\Livewire\Public\Auth\Register;
use App\Http\Livewire\Public\Category\ListCategoryProducts;
use App\Http\Livewire\Public\Order\CartPage;
use App\Http\Livewire\Public\Order\Checkout;
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
    Route::get('/cart', CartPage::class)->name('cart');
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::middleware('auth:web')->group(function () {
        Route::get('/account', UserAccount::class)->name('account');
        Route::get('/manage-addresses', ManageAddresses::class)->name('manage-addresses');
        Route::get('/checkout', Checkout::class)->name('checkout');
        Route::post('/order-confirmation', [OrderConfirmationController::class, 'store'])->name('receive-confirmation');
    });
});
