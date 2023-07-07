<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductConfiguration;
use App\Models\ProductItem;
use App\Models\ProductMeta;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class CreateProduct extends Component
{
    use LivewireAlert, WithFileUploads;

    public Product $product;
    public $uploads = [];
    public $variant_name = '';
    public $variation_id = '';
    public $variations;
    public $options = [];
    public $variants;
    // public $attributesSku;
    // public $skus;
    public $categories = [];
    public $editing = false;
    public $items;
    public $meta;
    public $images = [];
    public $delete_item_id;

    protected $rules = [
        'product.name' => 'required|min:3',
        'product.description' => 'required',
        'product.additional_info' => 'nullable',
        'product.category_id' => 'required',
        // 'product.base_price' => 'nullable',
        'product.status' => 'nullable',
        'product.visibility' => 'nullable',
        'meta.title' => 'nullable',
        'meta.keywords' => 'nullable',
        'meta.description' => 'nullable',
        // 'images' => 'required_if:product.status,Published',
        'items' => 'required_if:product.status,Published',
    ];

    protected $listeners = ['skuAdded', 'delete_variant', 'create_possible_variations'];

    public function mount(Product $product)
    {
        $this->categories = Category::all();
        $this->product = empty($product) ? new Product() : $product;
        $this->editing = $this->product->id == null ? false : true;
        $this->variations = Variation::with('options')->get();
        if ($this->editing) {
            $this->product->load('category', 'meta', 'items', 'items.configurations', 'items.configurations.option');
            // $this->variants = $this->product->attributes;
            $this->items = $this->product->items()->get();
            $this->meta = $this->product->meta;
            $this->emit('setEditorData', array(
                'description' => $this->product->descrtiption,
                'additional_info' => $this->product->additional_info,
            ));
        } else {
            // $this->skus = collect();
            // $this->attributesSku = collect();
            $this->items = collect();
            $this->meta = collect();
        }
        $this->images = $this->product->getMedia('products');
        $this->options = VariationOption::with('variation')->get();
    }

    public function render()
    {
        if (!empty($this->variation_id)) {
            $this->options = VariationOption::where('variation_id', $this->variation_id)->get();
        }
        return view('livewire.admin.create-product', [
            'variations' => Variation::with('options')->get(),
        ])
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function save()
    {
        $this->validate();
        $message = 'Hurray! Product has beed added successfully.';
        if ($this->editing) {
            $message = 'Hurray! Product has beed edited successfully.';
        }
        $has_multiple_options = false;

        $items = $this->product->items()->get();
        $min_price = $items->min('amount');
        $max_price = $items->max('amount');
        $display_price = '';
        if ($min_price == $max_price) {
            $display_price = '' . $min_price;
        } else {
            $display_price = $min_price . ' - ' . $max_price;
        }
        if ($items->count() > 1) {
            $has_multiple_options = true;
        }
        $this->product->display_price = $display_price;
        $this->product->has_multiple_options = $has_multiple_options;
        $this->product->save();
        if (!empty($this->meta['title'])) {
            ProductMeta::updateOrCreate(
                ['product_id' => $this->product->id],
                [
                    'title' => $this->meta['title'],
                    'keywords' => $this->meta['keywords'],
                    'description' => $this->meta['description'],
                ]
            );
        }

        foreach ($this->uploads as $upload) {
            $path = Storage::path('/livewire-tmp/' . $upload['fileRef']->getFileName());
            $this->product->addMedia($path)
                ->withResponsiveImages()
                ->toMediaCollection('products');
        }
        $this->alert('success', $message);
        if ($this->editing) {
            return redirect()->route('admin.productList');
        } else {
            return redirect()->route('admin.editProduct', ['product' => $this->product]);
        }
    }

    public function skuAdded($details)
    {
        if (empty($this->product->id)) {
            $this->product->save();
        }
        $item = $this->product->items()->create([
            'sku' => $details['item']['sku'],
            'amount' => $details['item']['amount'],
            'stock' => $details['item']['stock'],
        ]);
        $variants = [];
        if (!empty($details['selected_variants'])) {
            foreach ($details['selected_variants'] as $variant) {
                array_push(
                    $variants,
                    ['variation_option_id' => $variant]
                );
            }
            $item->configurations()->createMany($variants);
        }
        $this->items = $this->product->items()->get();
        // if ($details['editing'] == false) {
        //     $this->items->push($details['sku']);
        // } else {
        //     $this->items = $this->items->replace([
        //         $details['index'] => $details['sku']
        //     ]);
        // }
    }

    public function remove_uploaded_image($index)
    {
        $this->images[$index]->delete();
        $this->images = $this->product->getMedia('products');
    }

    public function remove_image($index)
    {
        $upload = $this->uploads[$index];
        Storage::delete('/livewire-tmp/' . $upload['fileRef']->getFileName());
        array_splice($this->uploads, $index, 1);
    }

    public function create_variant()
    {
        if ($this->variant_name == '') {
            $this->alert('warning', 'Enter a variant name!');
            return;
        }
        // $variant = new Attribute();
        // $variant->name = $this->variant->name;
        // $this->variants->push($variant);
    }

    // public function create_default_variants()
    // {
    //     $variant = new Variation();
    //     $variant->name = 'Color';
    //     $this->variants->push($variant);
    //     $variant = new Variation();
    //     $variant->name = 'Size';
    //     $this->variants->push($variant);
    // }

    public function open_sku_modal($id)
    {
        if (empty($this->product->name)) {
            $this->alert('warning', 'Please enter the product name to continue.');
            return;
        }
        if (empty($this->product->category_id)) {
            $this->alert('warning', 'Please select a category to continue.');
            return;
        }
        $params = [
            'name' => $this->product->name,
            //     'variants' => $this->variants,
        ];
        if (isset($id)) {
            $params['sku'] = $id;
        }
        $this->emit(
            'openModal',
            'admin.modal.create-product-item',
            $params,
        );
    }

    public function open_variation_modal()
    {
        if (empty($this->product->name)) {
            $this->alert('warning', 'Please enter the product name to continue.');
            return;
        }
        if (empty($this->product->category_id)) {
            $this->alert('warning', 'Please select a category to continue.');
            return;
        }

        $this->emit(
            'openModal',
            'admin.modal.select-variations-modal',
        );
    }

    public function create_possible_variations($data)
    {
        // $combinations = DB::select(DB::raw('SELECT a.variation_id as a_variation_id, b.variation_id as b_variation_id, a.id as a_id, b.id as b_id, a.value as a_value, b.value as b_value FROM `variation_options` a cross join `variation_options` b where a.variation_id > b.variation_id order by a.id'));

        if (empty($this->product->id)) {
            $this->product->save();
        }
        $amount = $data['base_price'];
        $combinations = $data['combinations'];
        $titles = $data['titles'];
        foreach ($combinations as $index => $combination) {
            $item = $this->product->items()->create([
                'sku' => Str::sku($this->product->name),
                'amount' => $amount,
                'display_name' => $titles[$index]
            ]);
            $item->configurations()->createMany($combination);
        }
        $this->items = $this->product->items()->get();
    }

    public function confirm_delete_item($id)
    {
        $this->delete_item_id = $id;
        $this->alert('question', 'Are you sure you want to delete?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, Confirm',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'position' => 'center',
            'timer' => null,
            'text' => 'This operation can not be reverted once done. Please confirm',
            'onConfirmed' => 'delete_variant',
        ]);
    }

    public function delete_variant()
    {
        if (!empty($this->delete_item_id)) {
            ProductConfiguration::where('product_item_id', $this->delete_item_id)->delete();
            ProductItem::destroy($this->delete_item_id);
            $this->delete_item_id = null;
            $this->items = $this->product->items()->get();
        }
    }
}
