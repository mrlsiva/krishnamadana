<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateProduct extends Component
{
    use LivewireAlert;

    public $product;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.admin.create-product')
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function save()
    {
    }
}
