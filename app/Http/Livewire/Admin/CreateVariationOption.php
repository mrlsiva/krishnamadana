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
}
