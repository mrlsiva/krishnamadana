<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public function render()
    {
        return view('livewire.admin.user-list', [
            'users' => User::latest()->paginate(25),
        ])
        ->extends('admin.dashboard')
            ->section('section');
    }
}
