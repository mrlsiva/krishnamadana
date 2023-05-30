<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowCollections extends Component
{
    public function render()
    {
        return view('livewire.show-collections')
            ->layout('public.base')
            ->slot('main');
    }
}
