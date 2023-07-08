<?php

namespace App\Http\Livewire\Public\Account;

use App\Models\Order;
use App\Models\UserAddress;
use Livewire\Component;

class UserAccount extends Component
{

    public $primary_address;
    public $address_count;
    public $orders;

    public function mount()
    {
        $userId = auth()->user()->id;
        $this->primary_address = UserAddress::with('state')->where([
            'user_id' => $userId,
            'is_default' => true
        ])->first();
        $this->address_count = UserAddress::with('state')->where([
            'user_id' => $userId,
            'is_default' => false
        ])->count();
        $this->orders = Order::where('user_id', $userId)->get();
    }

    public function render()
    {
        return view('livewire.public.account.user-account')
            ->extends('public.base')
            ->section('main');
    }
}
