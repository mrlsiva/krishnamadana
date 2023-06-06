<?php

namespace App\Http\Livewire\Admin\Modal;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CreateSku extends ModalComponent
{

    public array $variants;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.admin.modal.create-sku');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }
}
