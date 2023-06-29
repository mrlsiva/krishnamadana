<?php

namespace App\Http\Livewire\Public\Common;

use Livewire\Component;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Cart;

class Header extends Component
{

    public function mount()
    {
        Event::listen('cart.added', function ($items, $cart) {
            Log::debug('Header');
            Log::debug($items);
        });
    }

    public function render()
    {
        $items = \Cart::getContent();
        return view('livewire.public.common.header', [
            'items' => $items,
        ]);
    }
}
