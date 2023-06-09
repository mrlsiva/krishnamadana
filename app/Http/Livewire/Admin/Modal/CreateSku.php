<?php

namespace App\Http\Livewire\Admin\Modal;

use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class CreateSku extends ModalComponent
{

    public array $variants;
    public $sku;
    public $index;
    public $editing;

    public function mount()
    {
        if (!isset($this->sku['sku'])) {
            $this->sku['sku'] = Str::sku($this->name);
            $this->sku['variants'] = $this->variants;
            $this->editing = false;
        } else {
            $this->editing = true;
        }
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
        $this->emit('skuAdded', ['sku' => $this->sku, 'editing' => $this->editing, 'index' => $this->index]);
        $this->closeModal();
    }
}
