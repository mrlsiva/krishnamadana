<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeSku;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use LivewireAlert, WithFileUploads;

    public Product $product;
    public $uploads = [];
    public $variant_name = '';
    public $variants;
    public $skus;
    public $categories = [];
    public $editing = false;
    private $productService;

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
            $this->variants = collect($this->product->attributes);
            $this->skus = collect($this->product->skus);
            $this->emit('setEditorData', array(
                'description' => $this->product->descrtiption,
                'additional_info' => $this->product->additional_info,
            ));
        } else {
            $this->skus = collect();
            $this->variants = collect();
        }
        // $this->productService = $productService;
    }

    public function render()
    {
        return view('livewire.admin.create-product')
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function save(ProductService $productService)
    {
        $this->validate();
        $message = 'Hurray! Product has beed added successfully.';
        if ($this->editing) {
            $message = 'Hurray! Product has beed edited successfully.';
        }
        $this->product->save();
        $result = $productService->createOrUpdateProduct(
            $this->product,
            $this->variants,
            $this->skus,
        );
        if (!$result) {
            $this->alert('warning', 'Error updating the product details. Please try again.');
            return;
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
        if ($details['editing'] == false) {
            $this->skus->push($details['sku']);
        } else {
            $this->skus = $this->skus->replace([
                $details['index'] => $details['sku']
            ]);
        }
    }

    public function create_variant()
    {
        if ($this->variant_name == '') {
            $this->alert('warning', 'Enter a variant name!');
            return;
        }
        $this->variants->push([
            'name' => $this->variant_name,
        ]);
    }

    public function create_default_variants()
    {
        $this->variants->push([
            'name' => 'Color',
        ]);
        $this->variants->push([
            'name' => 'Size',
        ]);
    }

    public function open_sku_modal($index)
    {
        if (!$this->product->name) {
            $this->alert('warning', 'Please enter the product name before creating SKU.');
            return;
        }
        $sku = $index >= 0 ? $this->skus[$index] : [];
        $this->emit(
            'openModal',
            'admin.modal.create-sku',
            ['variants' => $this->variants, 'name' => $this->product->name, 'sku' => $sku, 'index' => $index]
        );
    }
}
