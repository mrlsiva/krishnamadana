<?php

namespace App\Http\Livewire\Public\Category;

use App\Models\Category;
use Livewire\Component;

class CategoryList extends Component
{
    public static function Categories()
    {
        $categories = Category::where(['active' => 1])->get();	
		return $categories;
    }   
}
