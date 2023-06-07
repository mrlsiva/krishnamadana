<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use LivewireAlert, WithFileUploads, LivewireAlert;

    public $product;
    public $uploads = [];
    public $variant_name = '';
    public $variants = [];
    public $skus = [];

    protected $listeners = ['skuAdded'];

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

    public function skuAdded($sku)
    {
        array_push($this->skus, $sku);
    }

    public function create_variant()
    {
        if ($this->variant_name == '') {
            $this->alert('warning', 'Enter a variant name!');
            return;
        }
        array_push($this->variants, array(
            'name' => $this->variant_name,
        ));
    }

    public function create_default_variants()
    {
        array_push($this->variants, array(
            'name' => 'Color',
        ));
        array_push($this->variants, array(
            'name' => 'Size',
        ));
    }
}
