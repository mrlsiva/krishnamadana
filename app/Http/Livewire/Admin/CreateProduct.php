<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Attribute;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use LivewireAlert, WithFileUploads, LivewireAlert;

    public Product $product;
    public $uploads = [];
    public $variant_name = '';
    public $variants = [];
    public $skus = [];
    public $categories = [];
    public $editing = false;

    protected $rules = [
        'product.name' => 'required|min:3',
        'product.description' => 'required',
        'product.additional_info' => 'nullable',
        'product.category_id' => 'required',
    ];

    protected $listeners = ['skuAdded'];

    public function mount(Product $product)
    {
        $this->categories = Category::all();
        $this->product = empty($product) ? new Product() : $product;
        $this->editing = $this->product->id == null ? false : true;
        if ($this->editing) {
            $this->product->load('attributes', 'skus', 'attributes.skus', 'skus.variants', 'category');
            $this->variants = $this->product->attributes;
            $this->skus = $this->product->skus;
            $this->emit('setEditorData', array(
                'description' => $this->product->descrtiption,
                'additional_info' => $this->product->additional_info,
            ));
        }
    }

    public function render()
    {
        return view('livewire.admin.create-product')
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
        $this->product->save();
        if (!empty($this->variants)) {
            $attributes_sku = [];
            foreach ($this->variants as $key => $variant) {
                $this->variants[$key]['product_id'] = $this->product->id;
            }
            $this->product->attributes()->upsert(
                $this->variants,
                ['product_id', 'name'],
                ['name'],
            );
        }
        $attributes = $this->product->attributes()->get();
        $attributes_sku = [];
        if (!empty($this->skus)) {
            $skus = [];
            foreach ($this->skus as $key => $sku) {
                $this->skus[$key]['product_id'] = $this->product->id;
                $this->skus[$key]['sku'] = $sku['sku_id'];
                array_push(
                    $skus,
                    array(
                        'product_id' => $this->product->id,
                        'sku' => $sku['sku_id'],
                        'amount' => $sku['amount'],
                        'stock' => $sku['stock'] ?? null,
                    ),
                );
            }
            $this->product->skus()->upsert(
                $skus,
                ['product_id', 'sku'],
                ['amount', 'stock'],
            );
            $skus = $this->product->skus()->get();
            foreach ($this->skus as $key => $sku) {
                foreach ($sku['variants'] as $variant) {
                    $attribute_id = $attributes->first(fn ($item) => $item->name == $variant['name'])->id;
                    $sku_id = $skus->first(fn ($item) => $item->sku = $sku['sku_id'])->id;
                    array_push(
                        $attributes_sku,
                        array(
                            'attribute_id' => $attribute_id,
                            'sku_id' => $sku_id,
                            'value' => $variant['value'],
                        ),
                    );
                }
            }
            $this->product->attributeSku()->upsert(
                $attributes_sku,
                ['attribute_id', 'sku_id'],
                ['value'],
            );
        }

        $this->alert('success', $message);
        if ($this->editing) {
            return redirect()->route('admin.productList');
        } else {
            return redirect()->route('admin.editProduct', ['product' => $this->product]);
        }
    }

    public function skuAdded($sku)
    {
        array_push($this->skus, $sku);
    }

    public function create_variant()
    {
        if ($this->variant_name == '') {
            $this->alert('warning', 'Enter a variant name!');
            return;
        }
        array_push($this->variants, array(
            'name' => $this->variant_name,
        ));
    }

    public function create_default_variants()
    {
        array_push($this->variants, array(
            'name' => 'Color',
        ));
        array_push($this->variants, array(
            'name' => 'Size',
        ));
    }
}
