<?php

namespace App\Http\Livewire\Public\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $email;
    public $password;

    protected $rules = [
        'email' => 'required',
        'password' => 'required|min:6',
    ];

    public function render()
    {
        return view('livewire.public.auth.login')
            ->extends('public.base')
            ->section('main');
    }

    public function login()
    {
        $credentials = $this->validate();
        if (Auth::guard('web')->attempt($credentials)) {
            session()->regenerate();
            return redirect()->route('home');
        }
    }
}
