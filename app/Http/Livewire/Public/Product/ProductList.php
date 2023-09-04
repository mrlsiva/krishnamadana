<?php
namespace App\Http\Livewire;
namespace App\Http\Livewire\Public\Product;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{

    use WithPagination;
   // protected $paginationTheme = 'bootstrap';

    public $sortBy;
    public $perPage;
    public $category;

    public $filters = [
        'categories' => [],
    ];

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 12;
        $this->category = [];
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

        // this is where we remove the categories with a false value
        $this->filters['categories'] = array_filter($this->filters['categories']);
        //$products =  Product::whereIn('category_id', array_keys($this->filters['categories']))->paginate($this->perPage);

        return view('livewire.public.product.product-list', ['products' => $products])
        ->extends('public.base')
        ->section('main');         
    }

    public function paginationView()
    {
       return 'livewire.public.paginate.pagination';
    }
   
}
