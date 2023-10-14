<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;

    use WithPagination;

    /* Get All Users  */
    public function index()
    {
        try {
            $user = User::paginate(12);   
		    return response()->json(['success' => true, 'data' => $user], $this->successStatus); 
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

    /* Get specific user  */
    public function getUserDetails(Request $request, $id)
    {
        try {
            $user = User::select('id', 'name', 'email', 'mobile')->where('id', $id)->first();
		    return response()->json(['success' => true, 'data' => $user], $this->successStatus); 
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
    
    /* Update User */
    public function editUser(Request $request, $id)
    {
        try {		
            $user = User::findOrFail($id);

			$validator = Validator::make($request->all(), [ 
                'name' => 'required',
				'email' => 'required|unique:users,email,'.$user->id,
				'mobile' => 'required|unique:users,mobile,'.$user->id,
				'password' => 'required|min:6|same:confirm_password',
				'confirm_password' => 'required|min:6',
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all(); 
            $input['password'] = Hash::make($input['password']);    
            
            $user->name = $input['name'];            
            $user->email = $input['email']; 
            $user->mobile = $input['mobile']; 
            $user->password = $input['password'];                    
            $user->save();       

            $message =  'User updated successfully';
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

     /* Delete User  */
     public function deleteUser(Request $request, $id)
     {
         try {	
             $user = User::findOrFail($id);
             $user->delete();
             
             $message = 'User deleted successfully';;
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
}
