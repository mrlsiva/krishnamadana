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
use App\Http\Livewire\Public\Product\ProductList;
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

//Artisan::call('storage:link');
Route::prefix('admin')->group(base_path('routes/admin_routes.php'));

Route::view('/', 'public.home')->name('home');
Route::name('home.')->group(function () {
    Route::get('/products', ProductList::class)->name('products');
    Route::get('/product/{slug}', ProductDetails::class)->name('product-details');
    Route::get('/collections/{slug}', ListCategoryProducts::class)->name('collections');
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


Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    return '<h1>All cache cleared</h1>';
});

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});