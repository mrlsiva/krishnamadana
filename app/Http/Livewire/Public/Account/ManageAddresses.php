<?php

namespace App\Http\Livewire\Public\Account;

use App\Models\UserAddress;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ManageAddresses extends Component
{

    use LivewireAlert;

    public $userId;
    public $addresses;

    protected $listeners = ['address_added'];

    public function mount()
    {
        $this->userId = auth()->user()->id;
        $this->fetch_addresses();
    }

    public function render()
    {
        return view('livewire.public.account.manage-addresses')
            ->extends('public.base')
            ->section('main');
    }

    public function open_address_modal()
    {
        $this->emit(
            'openModal',
            'public.modal.add-address'
        );
    }

    public function fetch_addresses()
    {
        $this->addresses = UserAddress::with('state')->where('user_id', $this->userId)->get();
    }

    public function address_added()
    {
        $this->fetch_addresses();
    }
}
