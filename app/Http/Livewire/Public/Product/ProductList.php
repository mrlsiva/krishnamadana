<?php

namespace App\Http\Livewire\Public\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{

    use WithPagination;
   // protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.public.product.product-list', [
            'products' => Product::paginate(12),
        ])
        ->extends('public.base')
        ->section('main');         
    }

     public function paginationView()
    {
       return 'livewire.public.paginate.pagination';
    } 
   
}
