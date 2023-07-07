<?php

namespace App\Providers;

use App\Services\RazorPayService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{


    public $singletons = [
        RazorPayService::class => RazorPayService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RazorPayService::class, function ($app) {
            return new RazorPayService();
        });
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

        Collection::macro('byVariationType', function ($variation) {
            return $this->filter(function ($value) use ($variation) {
                return $value->variation->name == $variation;
            });
        });
    }
}
