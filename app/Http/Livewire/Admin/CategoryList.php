<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class CategoryList extends Component
{

    public function render()
    {
        return view('livewire.admin.category-list', [
            'categories' => Category::with('media')->orderBy('order', 'asc')->get()
        ])
            ->extends('admin.dashboard')
            ->section('section');
    }
}
