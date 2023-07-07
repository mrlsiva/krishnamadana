<?php

namespace App\Http\Livewire\Public\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Register extends Component
{

    use LivewireAlert;

    public $confirm_password;
    public $password;
    public $user;
    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required|unique:users,email',
        'user.mobile' => 'required|unique:users,mobile',
        'password' => 'required|min:6|same:confirm_password',
        'confirm_password' => 'required|min:6',
    ];

    protected $messages = [
        'password.same' => 'Your password did not match with the confirm password.',
    ];

    public function mount()
    {
        $this->user = new User();
    }

    public function render()
    {
        return view('livewire.public.auth.register')
            ->extends('public.base')
            ->section('main');
    }

    public function submit()
    {
        $this->validate();

        $this->user->password = Hash::make($this->password);
        $this->user->save();
        // $this->alert('success', 'Registration Successful! Please login to continue.');
        session()->flash('register', 'Registration Successful! Please login to continue.');
        return redirect()->route('home.login');
    }
}
