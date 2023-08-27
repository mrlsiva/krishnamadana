<?php

namespace App\Http\Livewire\Public\Auth;

use App\Models\Product;
use App\Models\ShoppingSession;
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
            $items = ShoppingSession::where('user_id', auth()->user()->id)->get();
            ShoppingSession::where('user_id', auth()->user()->id)->delete();
            foreach ($items as $item) {
                $attribute = json_decode($item['attributes']);
                $product = Product::with('media', 'items', 'items.configurations', 'items.configurations.option', 'items.configurations.variation')->find($item['id']);
                $variant = $product->items()->where('id', $attribute->selected_variant->id)->first();
                if ($variant) {
                    \Cart::add(array(
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => $variant->amount,
                        'quantity' => 1,
                        'attributes' => array(
                            'selected_variant' => [
                                'id' => $variant->id,
                                'amount' => $variant->amount,
                            ],
                            'display_name' => $variant->display_name,
                        ),
                        'associatedModel' => $product
                    ));
                }
            }
            session()->regenerate();
            return redirect()->route('home');
        } else {
            session()->flash('loginError');
        }
    }
}
