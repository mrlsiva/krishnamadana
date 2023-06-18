<?php

namespace App\Providers;

use App\Services\ProductService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('isLinkActive', function ($routeName) {
            return "<?= Route::currentRouteName() == $routeName ? 'active' : ''; ?>";
        });
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService();
        });

        Collection::macro('byVariationType', function ($variation) {
            return $this->filter(function ($value) use ($variation) {
                return $value->variation->name == $variation;
            });
        });
    }
}
