<?php

namespace App\Providers;

use App\Models\ShoppingSession;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('cart.added', function ($item, $cart) {
            Log::debug('Added: ' . $item['id']);
            $this->update_cart_session($item);
        });
        Event::listen('cart.updated', function ($item, $cart) {
            Log::debug('Updated: ' . $item->id);
            $this->update_cart_session($item);
        });
        Event::listen('cart.removed', function ($id, $cart) {
            ShoppingSession::where([
                'user_id' => auth()->user()->id,
                'cart_id' => $id,
            ])->delete();
        });
        // Event::listen('cart.cleared', function ($cart) {
        //     ShoppingSession::where([
        //         'user_id' => auth()->user()->id,
        //     ])->delete();
        // });
    }

    private function update_cart_session($item)
    {
        ShoppingSession::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'cart_id' => $item['id'],
            ],
            [
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'attributes' => json_encode($item['attributes']),
                'associated_model_id' => $item['id'],
            ]
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
