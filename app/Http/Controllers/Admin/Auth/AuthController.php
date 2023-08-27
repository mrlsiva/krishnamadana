<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $input = $request->validated();
        if (Auth::guard('admin')->attempt($input)) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withInput($request->except('password'))->withErrors([
                'error' => 'Incorrect username or password.'
            ]);
        }
    }
}
