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
    public $selected_item;
    public $option_ids;
    public $selected_variation;

    public function mount($slug)
    {
        $this->product = Product::with('media', 'items', 'items.configurations', 'items.configurations.option', 'items.configurations.variation')->where('slug', $slug)->first();
        // $items_id = $this->product->items->pluck('id');
        // $variations = Variation::with('option', 'variation')->whereIn('product_item_id', $items_id)->get();
        $option_id = array();
        if ($this->product->items->count() > 0) {
            $this->selected_item = $this->product->items->first();
            $this->option_ids = $this->selected_item->configurations->pluck('variation_option_id');
            foreach ($this->product->items as $index => $item) {
                foreach ($item->configurations as $configuration) {
                    array_push($option_id, $configuration->variation_option_id);
                    // $this->selected_variation[$index] = $configuration->variation_option_id;
                }
            }
            $this->variations = Variation::whereHas('options', fn ($query) => $query->whereIn('id', $option_id))
                ->with(['options' => fn ($query) => $query->whereIn('id', $option_id)])
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.public.product.product-details')
            ->extends('public.base')
            ->section('main');
    }

    public function on_variant_change($index, $id)
    {
        $this->option_ids[$index] = $id;
        $options = $this->option_ids->toArray();
        foreach ($this->product->items as $item) {
            $ids = $item->configurations->pluck('variation_option_id')->toArray();
            if ($ids == $options) {
                $this->selected_item = $item;
                break;
            }
        }
    }
}
