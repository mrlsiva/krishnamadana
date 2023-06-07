<?php

namespace App\Http\Livewire\Admin\Modal;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class CreateSku extends ModalComponent
{

    public array $variants;
    public $sku_id;
    public $price;
    public $stock;
    public $sku = array();

    public function mount()
    {
        $this->sku['sku_id'] = Str::sku('Name');
        $this->sku['variants'] = $this->variants;
    }

    public function render()
    {
        return view('livewire.admin.modal.create-sku');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function create_sku()
    {
        $this->emit('skuAdded', $this->sku);
        $this->closeModal();
    }
}
