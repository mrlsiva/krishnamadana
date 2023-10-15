<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Order;
use Validator;
use Livewire\WithPagination;

class AdminOrderController extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;

    use WithPagination;

    /* Get All Orders  */
    public function index()
    {
        try {
            $order = Order::paginate(12);   
		    return response()->json(['success' => true, 'data' => $order], $this->successStatus); 
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

    /* Get specific Order Details */
    public function getOrderDetails(Request $request, $id)
    {
        try {
            $order = Order::select('user_id', 'order_id', 'payment_id', 'amount', 'discount', 'payment_status', 'user_address_id', 'notes')->where('id', $id)->first();
		    return response()->json(['success' => true, 'data' => $order], $this->successStatus); 
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

    /* Update Order */
    public function editOrder(Request $request, $id)
    {
        try {	
            $validator = Validator::make($request->all(), [ 
                'discount' => 'nullable',
                'payment_status' => 'required',           
            ]);
            if ($validator->fails()) {   
                $message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all();            
            
            $order = Order::findOrFail($id);
            $order->discount = isset($input['discount']) ? $input['discount'] : '0.00';            
            $order->payment_status = $input['payment_status'];                            
            $order->save();       

            $message =  'Order updated successfully';
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
