<?php

namespace App\Http\Livewire\Public\Modal;

use App\Models\State;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class AddAddress extends ModalComponent
{

    public $states;
    public $address;

    protected $rules = [
        'address.name' => 'required',
        'address.mobile' => 'required',
        'address.address_line1' => 'required',
        'address.address_line2' => 'nullable',
        'address.landmark' => 'nullable',
        'address.city' => 'required',
        'address.pincode' => 'required',
        'address.state_id' => 'required|exists:states,id',
        'address.is_default' => 'nullable',
    ];

    public function mount()
    {
        $this->states = State::all();
        $this->address = new UserAddress();
    }

    public function render()
    {
        return view('livewire.public.modal.add-address');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function save_address()
    {
        $this->validate();
        $userId = auth('web')->user()->id;
        if ($this->address->is_default) {
            UserAddress::where('user_id', $userId)->update([
                'is_default' => false,
            ]);
        }
        $this->address->is_default = $this->address->is_default ?? false;
        $this->address->user_id = $userId;
        $this->address->save();
        $this->emit('address_added', $this->address->id);
        $this->closeModal();
    }
}
