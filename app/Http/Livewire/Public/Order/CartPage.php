<?php

namespace App\Http\Livewire\Public\Order;

use Livewire\Component;
use Cart;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Support\Facades\Log;

class CartPage extends Component
{
    public function render()
    {
        return view('livewire.public.order.cart')
            ->extends('public.base')
            ->section('main');
    }

    public function remove_item($id)
    {
        \Cart::remove($id);
    }

    public function reduce_quantity($id)
    {
        $selected = \Cart::get($id);
        if ($selected['quantity'] == 1) {
            $this->remove_item($id);
        } else {
            \Cart::update($id, array(
                'quantity' => -1,
            ));
        }
    }

    public function increase_quantity($id)
    {
        $selected = \Cart::get($id);
        if ($selected['quantity'] > 9) {
            return;
        }
        \Cart::update($id, array(
            'quantity' => 1,
        ));
    }
}
