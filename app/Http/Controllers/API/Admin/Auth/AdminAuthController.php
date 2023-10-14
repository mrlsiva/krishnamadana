<?php

namespace App\Http\Controllers\API\Admin\Auth;
//namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;

class AdminAuthController extends Controller
{

    public $successStatus = 200;
	public $errorStatus = 400;
    
    /* ADMIN API's */
	public function adminLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
			$userId = $user->id; 
			$name = $user->name;

			$success['userId'] = $userId;
			$success['username'] = $name;
              
            $success['token'] = $user->createToken('KrishnamadanaAdminToken')->accessToken;        

			$message = 'Admin user logged in successfully';
			return response()->json(['success' => true, 'data' => $success, 'message' => $message], $this->successStatus); 
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function adminLogout(Request $request)
    {
        $request->user('admin')->token()->revoke();
       
        $message = 'Successfully logged out'; 
        return response()->json(['success'=> true, 'message'=> $message], $this->successStatus); 
    }
}
