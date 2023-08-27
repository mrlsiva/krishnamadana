<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{

    use WithPagination;

    public function render()
    {
        return view('livewire.admin.product-list', [
            'products' => Product::paginate(10),
        ])
            ->layout('admin.dashboard')
            ->slot('section');
    }
}
