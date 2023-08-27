<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class OrderList extends Component
{
    public function render()
    {
        return view('livewire.admin.order-list', [
            'orders' => Order::with('order_items', 'order_items.product', 'shipping_address')->latest()->paginate(1),
        ])
        ->extends('admin.dashboard')
        ->section('section');
    }
}
