<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderStatus;

class AdminOrderStatus extends Component
{
    public $order;
    public $status;
    public $order_id;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->status = $order->status;
        $this->order_id = $order->order_id;
    }

    public function updateStatus()
    {
        $this->validate([
            //'status' => 'required|in:pending,processing,shipped,delivered',
            'status' => 'required',
            'order_id' => 'required',
        ]);

   

        //$this->order->update(['status' => $this->status]);

        OrderStatus::where('order_item_id', $this->order_id)->update([
            'status_id' => $this->status,
        ]);

        session()->flash('message', 'Order status updated successfully.');

       // $this->emit('orderStatusUpdated');
    }

    public function render()
    {
        return view('livewire.admin-order-status');
    }
}
