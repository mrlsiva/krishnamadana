<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\RazorPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Cart;

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
        Log::debug($input);
        Log::debug($verified);
        if (!$verified) {
            $error = 'PAYMENT_ERROR';
            $error_message = 'Your payment could not be verified. Please try again or contact our support.';
            return view('public.order-confirmed', compact('error_message', 'error'));
        }
        $payment = $razorPayService->fetch_payment($input['razorpay_payment_id']);
        $razorPayService->capture_payment($input['razorpay_payment_id'], $payment['amount']);
        Order::where('order_id', $input['razorpay_order_id'])->update([
            'payment_id' => $input['razorpay_payment_id'],
            'payment_status' => 'confirmed',
        ]);
        \Cart::clear();
        return view('public.order-confirmed', ['order_id' => $input['razorpay_order_id']]);
    }
}
