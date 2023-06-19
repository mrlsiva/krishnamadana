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
        $this->products = Product::with('media')->limit(4)->get();
    }

    public function render()
    {
        Log::debug($this->products);
        return view('livewire.public.home.best-sellers');
    }
}
