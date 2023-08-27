<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderSession;
use App\Models\OrderStatus;
use App\Models\Status;
use App\Services\RazorPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Cart;
use Illuminate\Support\Facades\DB;

class OrderConfirmationController extends Controller
{
    public function store(Request $request, RazorPayService $razorPayService)
    {

        $input = $request->all();
        $error = '';
        $error_message = '';
        if (!isset($input['razorpay_signature']) || empty($input['razorpay_signature'])) {
            $error = 'PARAMETER_ERROR';
            $error_message = 'Your request is invalid. Please try again.';
            return view('public.order-confirmed', compact('error_message', 'error'));
        }
        $verified = $razorPayService->verify_signature(
            $input['razorpay_signature'],
            $input['razorpay_payment_id'],
            $input['razorpay_order_id']
        );
        if (!$verified) {
            $error = 'PAYMENT_ERROR';
            $error_message = 'Your payment could not be verified. Please try again or contact our support.';
            return view('public.order-confirmed', compact('error_message', 'error'));
        }
        $payment = $razorPayService->fetch_payment($input['razorpay_payment_id']);
        $razorPayService->capture_payment($input['razorpay_payment_id'], $payment['amount']);
        $user = auth()->user();
        $session_order = OrderSession::where('order_id', $input['razorpay_order_id'])->first();
        Log::debug($input);
        Log::debug($session_order);
        try {
            DB::beginTransaction();
            $newOrder = Order::create([
                'user_id' => $user->id,
                'order_id' => $session_order->order_id,
                'payment_id' => $input['razorpay_payment_id'],
                'amount' => $session_order->amount,
                'discount' => $session_order->discount,
                'payment_status' => 'Confirmed',
                'notes' => $session_order->notes,
                'user_address_id' => $session_order->user_address_id,
            ]);
            $pending_status = Status::where('status', 'Order Received')->first();
            foreach (\Cart::getContent() as $item) {
                $order_item = OrderItems::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'product_item_id' => $item->attributes['selected_variant']['id'],
                    'variant_name' => $item->attributes['display_name'] ?? $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);
                OrderStatus::create([
                    'order_item_id' => $order_item->id,
                    'status_id' => $pending_status->id,
                ]);
            }

            DB::commit();
            $session_order->delete();
            \Cart::clear();
            return view('public.order-confirmed', ['order_id' => $input['razorpay_order_id']]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e);
            $error = 'ORDER_UPDATE_ERROR';
            $error_message = 'There was an error while processing your order. But don\'t worry, please contact our support for further assistance.';
            return view('public.order-confirmed', compact('error_message', 'error'));
        }
    }
}
