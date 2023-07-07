<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class RazorPayService
{

    private $keyId;
    private $secret;
    private $api;

    public function __construct()
    {
        $this->keyId = config('app.razorpay_keyid');
        $this->secret = config('app.razorpay_secret');
        $this->api = new Api($this->keyId, $this->secret);
    }

    public function create_order($receipt, $amount, $notes = [])
    {
        $options = [
            'receipt' => $receipt,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'notes' => $notes,
        ];
        return $this->api->order->create($options);
    }

    public function verify_signature($signature, $paymentId, $orderId)
    {
        try {
            $attributes = array(
                'razorpay_signature'  => $signature,
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id'   => $orderId,
            );
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            Log::debug($e);
            return false;
        }
    }

    public function fetch_payment($paymentId)
    {
        return $this->api->payment->fetch($paymentId);
    }

    public function capture_payment($paymentId, $amount)
    {
        return $this->api->payment->fetch($paymentId)->capture(['amount' => $amount]);
    }

    public function fetch_single_order($orderId)
    {
        return $this->api->order->fetch($orderId);
    }
}
