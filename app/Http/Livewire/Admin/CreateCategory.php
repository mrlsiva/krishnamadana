<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateCategory extends Component
{
    use LivewireAlert, WithFileUploads;

    public $name;
    public $order = 1;
    public $mediaComponentNames = ['image'];
    public $image;
    public $isResponsive;

    protected $rules = [
        'name' => 'required|min:3',
        'image' => 'required|file|mimes:jpg,png,webp',
        'order' => 'required|numeric'
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
        $category = Category::create([
            'name' => $this->name,
            'order' => $this->order,
        ]);
        $category->addMedia($this->image->getRealPath())
            ->withResponsiveImages()
            ->withResponsiveImagesIf($this->isResponsive == 'yes')
            ->toMediaCollection('categories');
        $this->alert('success', 'Category is added successfully!');
        $this->name = '';
        $this->order = 1;
        $this->isResponsive = null;
        $this->remove_image();
    }

    public function remove_image()
    {
        $this->image = null;
    }
}
