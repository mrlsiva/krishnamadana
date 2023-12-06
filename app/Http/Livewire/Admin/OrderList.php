<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Models\Status;

class OrderList extends Component
{
	public $statuses;
	
	public function mount()
    {       
        $this->statuses = Status::get();	       
    }
	
    public function render()
    {
        return view('livewire.admin.order-list', [
            'orders' => Order::with('order_items', 'order_items.product', 'shipping_address', 'order_items.statuses.status' )->latest()->paginate(10),
        ])
        ->extends('admin.dashboard')
        ->section('section');
    }
}
