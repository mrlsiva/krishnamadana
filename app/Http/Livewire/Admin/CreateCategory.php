<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateCategory extends Component
{
    use LivewireAlert;

    public $name;

    protected $rules = [
        'name' => 'required|min:3',
    ];


    public function render()
    {
        return view('livewire.admin.create-category')
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function save()
    {
        $this->validate();
        Category::create([
            'name' => $this->name
        ]);
        $this->alert('success', 'Category is added successfully!');
        $this->name = '';
    }
}
