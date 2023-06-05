<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use LivewireAlert, WithFileUploads;

    public $product;
    public $uploads = [];

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
