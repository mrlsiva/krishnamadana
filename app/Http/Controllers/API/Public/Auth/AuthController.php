<?php

namespace App\Http\Controllers\API\Public\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Cart;
use Darryldecode\Cart\Cart as CartCart;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Product;
use App\Models\Order;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
	public $successStatus = 200;
	public $errorStatus = 400;
	
    public $email;
    public $password;	
	public $confirm_password;
  
	/** 
     * Login user and create token
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request)
    {        

		try { 
			$validator = Validator::make($request->all(), [ 
                'email' => 'required',
				'password' => 'required|min:6',
            ]);
            if ($validator->fails()) { 
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401);            
            }		
		
			if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
			
				$user = Auth::user(); 
				$userId = $user->id; 
				$name = $user->name;

				$success['userId'] = $userId;
				$success['username'] = $name;
				
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
									
				$success['token'] =  $user->createToken('Krishnamadana')->accessToken; 
				$message = 'User logged in successfully';
				return response()->json(['success' => true, 'data' => $success, 'message' => $message], $this->successStatus); 
			} else {            
				return response()->json(['error'=>'Invalid UserName or Password'], 401); 
			}
		}
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }  
    }
	
	
	/* Register api 
     * Create user
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        try {
             $validator = Validator::make($request->all(), [ 
                'name' => 'required',
				'email' => 'required|unique:users,email',
				'mobile' => 'required|unique:users,mobile',
				'password' => 'required|min:6|same:confirm_password',
				'confirm_password' => 'required|min:6',
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all(); 
            $input['password'] = Hash::make($input['password']);                            
            
            $user = User::create($input); 

            //$success['token'] =  $user->createToken('MyApp')->accessToken; 
            $message =  'Registration Successful! Please login to continue.';

            return response()->json(['success'=> true, 'message' => $message], $this->successStatus); 
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }        
    }
	
	
	/* My Account api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function myAccount() 
    { 
		try {
			$userId = Auth::user()->id;
			$primary_address = UserAddress::with('state')->where([
				'user_id' => $userId,
				'is_default' => true
			])->first();			
			$address_count = UserAddress::with('state')->where([
				'user_id' => $userId,
				'is_default' => false
			])->count();
			$orders = Order::with('shipping_address', 'order_items', 'order_items.product', 'order_items.product.media', 'order_items.statuses', 'order_items.statuses.status')
				->where('user_id', $userId)->get();			
			
			$success['primary_address'] =  $primary_address;
			$success['address_count'] =  $address_count;
			$success['orders'] =  $orders;			
			return response()->json(['success'=> true, 'data' => $success], $this->successStatus); 
		}
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
	}
	
	
	/* Save/Update Address api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function saveAddress(Request $request) 
    { 
		try {
			$userId = Auth::user()->id;
			$validator = Validator::make($request->all(), [ 
                'name' => 'required',
				'mobile' => 'required',
				'address_line1' => 'required',
				'address_line2' => 'nullable',
				'landmark' => 'nullable',
				'city' => 'required',
				'pincode' => 'required',
				'state_id' => 'required|exists:states,id',
				'is_default' => 'nullable',
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 			
			
			$hasAddress = UserAddress::with('state')->where([
				'user_id' => $userId
			])->first();				
			
			if ( $hasAddress ) {
				UserAddress::where('user_id', $userId)->update($input);
				$message = 'Address updated successfully.';
			} else {
				$userAddress = new UserAddress($input);
				
				$primary_addresses = UserAddress::where([
					'user_id' => $userId,
					'is_default' => true,
				])->whereNot('id', $userAddress->id)->count();
				
				if ($primary_addresses == 0) {
					$userAddress->is_default = true;
				}
				$userAddress->pincode = $input['pincode'];
				$userAddress->user_id = $userId;
				
				$userAddress->save();
				$message = 'Address saved successfully.';
			}	
						
			return response()->json(['success'=> true, 'message' => $message], $this->successStatus); 
		}
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
	}
	
	/* Delete Address api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteAddress(string $id) 
    { 
		try {						
			if ($id != null) {
				$address = UserAddress::where('id', $id)->first();			

				if( $address ){
					$address->delete();
					$message = 'Address has been deleted successfully';		
					return response()->json(['success'=> true, 'message' => $message], $this->successStatus); 
				} else{
					$message = 'Address Not Found';		
					return response()->json(['success'=> false, 'message' => $message], $this->successStatus);
				}	
					
			} else {
				$message = 'Invalid Address ID';	
				return response()->json(['success'=> false, 'message' => $message], $this->successStatus); 	
			}	
			
		}
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
	}
	
	
	
	
	
	/**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {       
        Auth::logout();
		$request->user()->token()->revoke();
		\Cart::clear();
        session()->regenerate();
		
        $message = 'Successfully logged out'; 
        return response()->json(['success'=> true, 'message'=> $message], $this->successStatus); 
    }
	
	
}
