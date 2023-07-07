<?php

namespace App\Http\Livewire\Public\Order;

use App\Models\OrderItems;
use App\Models\OrderStatus;
use App\Models\Status;
use App\Models\UserAddress;
use App\Services\RazorPayService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Checkout extends Component
{
    use LivewireAlert;

    public $addresses;
    public $selected;
    public $transaction_id;
    public $notes;
    protected RazorPayService $razorPayService;

    protected $listeners = ['address_added'];

    protected $rules = [
        'notes' => 'nullable',
    ];

    public function boot(RazorPayService $razorPayService)
    {
        $this->razorPayService = $razorPayService;
    }

    public function mount()
    {
        $userId = auth()->user()->id;
        $this->addresses = UserAddress::with('state')->where('user_id', $userId)->get();
        $address = $this->addresses->where('is_default', true)->first();
        if ($address) {
            $this->selected = $address->id;
        }
    }

    public function render()
    {
        return view('livewire.public.order.checkout')
            ->extends('public.base')
            ->section('main');
    }

    public function select_address($id)
    {
        $this->selected = $id;
    }

    public function open_address_modal()
    {
        $this->emit(
            'openModal',
            'public.modal.add-address'
        );
    }

    public function address_added($id)
    {
        $userId = auth()->user()->id;
        $this->addresses = UserAddress::with('state')->where('user_id', $userId)->get();
        $this->selected = $id;
    }

    public function continue_checkout()
    {
        if (empty($this->selected)) {
            $this->alert('error', 'Please select a delivery address to continue checkout');
            return;
        }

        $total = \Cart::getTotal();
        $this->transaction_id = substr(md5(uniqid(mt_rand(), true)), 0, 15);
        $order = $this->razorPayService->create_order($this->transaction_id, $total, []);
        $user = auth()->user();
        $merchant_key = config('app.razorpay_keyid');
        try {
            DB::beginTransaction();

            $newOrder = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_id' => $this->transaction_id,
                'amount' => $total,
                'discount' => 0,
                'payment_status' => 'Pending',
                'notes' => $this->notes,
                'user_address_id' => $this->selected,
            ]);
            $pending_status = Status::where('status', 'Order Received')->first();
            foreach (\Cart::getContent() as $item) {
                $order_item = OrderItems::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'product_item_id' => $item->attributes['selected_variant']['id'],
                    'variant_name' => $item->attributes['display_name'] ?? $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);
                OrderStatus::create([
                    'order_item_id' => $order_item->id,
                    'status_id' => $pending_status->id,
                ]);
            }

            $options = array(
                'key' => $merchant_key,
                'amount' => $total * 100,
                'name' => config('app.name'),
                'order_id' => $order->id,
                'callback_url' => route('home.receive-confirmation', ['_token' => csrf_token()]),
                'prefill' => array(
                    'name' => $user->name,
                    'email' => $user->email,
                    'contact' => $user->mobile,
                ),
            );
            DB::commit();
            $this->emit('openCheckout', $options);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('warning', 'Error placing your order. Please try again later.');
        }
    }
}
