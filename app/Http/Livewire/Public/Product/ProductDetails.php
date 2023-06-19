<?php

namespace App\Http\Livewire\Public\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ProductDetails extends Component
{

    public Product $product;

    public function mount($slug)
    {
        $this->product = Product::with('media')->where('slug', $slug)->first();
        Log::debug($this->product);
    }

    public function render()
    {
        return view('livewire.public.product.product-details')
            ->extends('public.base')
            ->section('main');
    }
}
