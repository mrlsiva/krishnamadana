<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CategoryList extends Component
{
    use LivewireAlert;

    public $delete_id;

    protected $listeners  = [
        'delete_category'
    ];

    public function render()
    {
        return view('livewire.admin.category-list', [
            'categories' => Category::with('media')->orderBy('order', 'asc')->get()
        ])
            ->extends('admin.dashboard')
            ->section('section');
    }

    public function confirm_delete($id)
    {
        $products = Product::where('category_id', $id)->count();
        if ($products > 0) {
            $this->alert('error', "You can not delete this category since this category has $products products. Please change the category of those products before delete this category.", [
                'timer' => 8000,
            ]);
            return;
        }
        $this->delete_id = $id;
        $this->alert('question', 'Are you sure you want to delete?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, Confirm',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'position' => 'center',
            'timer' => null,
            'text' => 'You can not revert this operation and any product associated with this category will be uncategorized.',
            'onConfirmed' => 'delete_category',
        ]);
    }

    public function delete_category() {
        if (!empty($this->delete_id)) {
            Category::destroy($this->delete_id);
            $this->delete_id = null;
        }
    }
}
