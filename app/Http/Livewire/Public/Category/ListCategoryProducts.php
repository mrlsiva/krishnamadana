<?php

namespace App\Http\Livewire\Public\Category;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ListCategoryProducts extends Component
{

    public $products;

    public function mount($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $this->products = Product::published()->where('category_id', $category->id)->with('media')->get();
    }

    public function render()
    {
        return view('livewire.public.category.list-category-products')
            ->extends('public.base')
            ->section('main');
    }
}
