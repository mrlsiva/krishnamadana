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
    public $delete_address_id;

    protected $listeners = ['address_added', 'delete_address'];

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

    public function open_address_modal($id = null)
    {
        $data = array(
            'address_id' => $id
        );

        $this->emit(
            'openModal',
            'public.modal.add-address',
            $data,
        );
    }

    public function fetch_addresses()
    {
        $this->addresses = UserAddress::with('state')->where('user_id', $this->userId)->orderBy('is_default', 'desc')->get();
    }

    public function address_added()
    {
        $this->fetch_addresses();
    }

    public function show_confirm_alert($id)
    {
        $this->delete_address_id = $id;
        $this->alert('question', 'Are you sure you want to delete?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, Confirm',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'position' => 'center',
            'timer' => null,
            'text' => 'This operation can not be reverted once done. Please confirm',
            'onConfirmed' => 'delete_address',
        ]);
    }

    public function delete_address()
    {
        if ($this->delete_address_id != null) {
            $address = UserAddress::where('id', $this->delete_address_id)->first();
            $other = UserAddress::whereNot('id', $this->delete_address_id)->first();
            if ($address->is_default && $other != null) {
                $other->is_default = true;
                $other->save();
                $address->is_default = false;
                $address->save();
            }
            $address->delete();
            $this->delete_address_id = null;
            $this->alert('success', 'Address has been deleted successfully');
            $this->fetch_addresses();
        }
    }
}
