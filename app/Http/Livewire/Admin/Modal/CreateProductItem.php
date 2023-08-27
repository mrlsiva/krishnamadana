<?php

namespace App\Http\Livewire\Admin\Modal;

use App\Models\ProductItem;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class CreateProductItem extends ModalComponent
{

    public $variants;
    public $selected_variants;
    public $item;
    // public $options;
    // public ProductItem $item;
    // public $index;
    // public $editing;
    // public $available_variants = array();
    public $name;

    protected $rules = [
        'item.sku' => 'required',
        'item.amount' => 'required',
        'item.stock' => 'nullable',
    ];

    public function mount()
    {
        $this->variants = Variation::whereHas('options')->with('options')->get();
        if (empty($this->item)) {
            $this->item = new ProductItem();
            $this->item->sku = Str::sku($this->name);
        }
        // if (empty($this->item)) {
        //     $this->item = new ProductItem();
        //     $this->item->sku = Str::sku($this->name);
        //     $this->editing = false;
        //     $this->options = collect();
        //     $this->available_variants = array_map(fn ($item) => $item['name'], $this->variants);
        // } else {
        //     $this->editing = true;
        // }
        // foreach ($this->variants as $variant) {
        //     $a_sku = $this->sku->sku;
        //     $a_name = $variant['name'];
        //     $a_attribute_id = '';
        //     $a_sku_id = '';
        //     $a_value = '';
        //     if ($variant['skus'] && sizeof($variant['skus']) > 0 && $this->editing) {
        //         $a_attribute_id = $variant['skus'][0]['attribute_id'];
        //         $a_sku_id = $variant['skus'][0]['sku_id'];
        //         $a_value = $variant['skus'][0]['value'];
        //     }
        //     array_push($this->attributesSku, [
        //         'sku' => $a_sku,
        //         'name' => $a_name,
        //         'attribute_id' => $a_attribute_id,
        //         'sku_id' => $a_sku_id,
        //         'value' => $a_value,
        //     ]);
        // }
    }

    public function render()
    {
        return view('livewire.admin.modal.create-product-item');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    // public function add_option($variant_name)
    // {
    //     $option = new VariationOption();
    //     $option->name = $variant_name;
    //     $this->options->push($option);
    //     $key = array_search($variant_name, $this->available_variants);
    //     array_splice($this->available_variants, $key, 1);
    // }

    public function create_sku()
    {
        // Log::debug($this->sku);
        // Log::debug($this->attributesSku);
        // Log::debug($this->variants);

        $data = [
            'item' => $this->item,
            // 'editing' => $this->editing,
            // 'index' => $this->index,
            'selected_variants' => $this->selected_variants,
        ];
        // $newItem = $this->item->save();
        // $configurations = array();
        // foreach ($this->selected_variants as $variant) {
        //     array_push($configurations, [
        //         'product_item_id' => $newItem->id,
        //         'variation_option->id' => $variant,
        //     ]);
        // }
        // $newItem->configurations()->createMany($configurations);
        // Log::debug($this->selected_variants);
        $this->emit('skuAdded', $data);
        $this->closeModal();
    }
}
