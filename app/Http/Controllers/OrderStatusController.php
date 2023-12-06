<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderStatusController extends Controller{
   
    public function updateOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'status' => 'required',
			'order_id' => 'required'              
		]);
		if ($validator->fails()) {   
			return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
		}
		$input = $request->all();             

        OrderStatus::where('order_item_id',$input['order_id'])->update([
            'status_id' => $input['status'],
        ]);      
		
		session()->flash('message', 'Order status updated successfully.');
		
       return redirect()->back()->with('success', 'Order status updated successfully'); 
    }   
}
