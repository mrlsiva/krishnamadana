<?php

namespace App\Http\Livewire\Public\Home;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PgSql\Lob;

class BestSellers extends Component
{

    public $products;

    public function mount()
    {
        $this->products = Product::published()->with('media')->limit(4)->get();
    }

    public function render()
    {
        return view('livewire.public.home.best-sellers');
    }
}
