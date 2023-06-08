<?php

namespace App\Http\Livewire\Public\Home;

use App\Models\Category;
use Livewire\Component;

class ShowCategories extends Component
{
    public function render()
    {
        return view('livewire.public.home.show-categories', [
            'categories' => Category::with('media')->get(),
        ]);
    }
}
