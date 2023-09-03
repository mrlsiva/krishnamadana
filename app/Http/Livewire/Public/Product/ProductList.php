<?php
namespace App\Http\Livewire;
namespace App\Http\Livewire\Public\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{

    use WithPagination;
   // protected $paginationTheme = 'bootstrap';

    public $sortBy;
    public $perPage;

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 12;
    }

    public function render()
    {
        if ($this->sortBy == 'featured') {
            $products = Product::where('featured', true)->paginate($this->perPage);
        } else if ($this->sortBy == 'a-z') {
            $products = Product::orderBy('name', 'asc')->paginate($this->perPage);
        } else if ($this->sortBy == 'z-a') {
            $products = Product::orderBy('name', 'desc')->paginate($this->perPage);        
        } else if ($this->sortBy == 'latest') {
            $products = Product::latest()->paginate($this->perPage);
        } else if ($this->sortBy == 'oldest') {
            $products = Product::oldest()->paginate($this->perPage);
        }else if ($this->sortBy == 'low') {
            $products = Product::orderBy('display_price', 'asc')->paginate($this->perPage);
        } else if ($this->sortBy == 'heigh') {
            $products = Product::orderBy('display_price', 'desc')->paginate($this->perPage);
        } else {
            $products = Product::paginate($this->perPage);
        }

        return view('livewire.public.product.product-list', ['products' => $products])
        ->extends('public.base')
        ->section('main');         
    }

    public function paginationView()
    {
       return 'livewire.public.paginate.pagination';
    }
   
}
