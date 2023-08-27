<?php

namespace App\Http\Livewire\Admin;

use App\Models\Variation;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateProductVariation extends Component
{
    use LivewireAlert;

    public $name;
    protected $rules = [
        'name' => 'required',
    ];
    public $delete_id;

    public function render()
    {
        return view('livewire.admin.create-product-variation', [
            'variations' => Variation::all(),
        ])
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function add_variation()
    {
        $this->validate();
        Variation::create([
            'name' => $this->name
        ]);
        $this->alert('success', 'Product variation added successfully.');
        $this->name = '';
    }

    public function confirm_delete($id)
    {
        $this->delete_id = $id;
        $this->alert('question', 'Are you sure you want to delete?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, Confirm',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'position' => 'center',
            'timer' => null,
            'text' => 'Deleting a variation deleting all the variations attached to a product also.',
            'onConfirmed' => 'delete_variant',
        ]);
    }

    public function getListeners()
    {
        return [
            'delete_variant'
        ];
    }

    public function delete_variant()
    {
        if (!empty($this->delete_id)) {
            Variation::destroy($this->delete_id);
            $this->delete_id = null;
        }
    }
}
