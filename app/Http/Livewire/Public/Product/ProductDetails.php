<?php

namespace App\Http\Livewire\Public\Product;

use App\Models\Product;
use App\Models\ProductConfiguration;
use App\Models\Variation;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ProductDetails extends Component
{

    public Product $product;
    public $variations;

    public function mount($slug)
    {
        $this->product = Product::with('media', 'items', 'items.configurations', 'items.configurations.option', 'items.configurations.variation')->where('slug', $slug)->first();
        // $items_id = $this->product->items->pluck('id');
        // $variations = Variation::with('option', 'variation')->whereIn('product_item_id', $items_id)->get();
        $option_id = array();
        foreach ($this->product->items as $item) {
            foreach ($item->configurations as $configuration) {
                array_push($option_id, $configuration->variation_option_id);
            }
        }
        $this->variations = Variation::whereHas('options', fn ($query) => $query->whereIn('id', $option_id))
            ->with(['options' => fn ($query) => $query->whereIn('id', $option_id)])
            ->get();
    }

    public function render()
    {
        return view('livewire.public.product.product-details')
            ->extends('public.base')
            ->section('main');
    }
}
