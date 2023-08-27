<?php

namespace App\Http\Livewire\Admin;

use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateVariationOption extends Component
{
    use LivewireAlert;

    public $variation_id;
    public $value;
    public $delete_id;

    protected $rules = [
        'variation_id' => 'required',
        'value' => 'required',
    ];

    public function render()
    {
        $variations = Variation::all();
        return view('livewire.admin.create-variation-option', [
            'variations' => $variations,
            'options' => VariationOption::with('variation')->get(),
        ])
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function add_option()
    {
        $this->validate();
        VariationOption::create([
            'variation_id' => $this->variation_id,
            'value' => $this->value,
        ]);
        $this->value = '';
        $this->alert('success', 'Variation option added successfully.');
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
            'onConfirmed' => 'delete_variant_option',
        ]);
    }

    public function getListeners()
    {
        return [
            'delete_variant_option'
        ];
    }

    public function delete_variant_option()
    {
        if (!empty($this->delete_id)) {
            VariationOption::destroy($this->delete_id);
            $this->delete_id = null;
        }
    }
}
