@extends('public.base')

@section('main')
    @empty($error_message)
        <section class="w-full md:w-2/3 mx-auto my-8 relative">
            <h2 class="text-center text-2xl font-semibold tracking-wider">Order Confirmed</h2>
            <div class="absolute w-full h-full">
                <lottie-player src="/anim/confetti-effects.json" background="transparent" speed="1" autoplay>
                </lottie-player>
            </div>
            <div class="flex flex-col items-center">
                <img src="/images/order_confirmed.svg" alt="Order confirmed." class="w-96 h-auto my-4" />
                <p class="text-xl">Yaayy! Your order has been confirmed. And your order id is:
                    <strong>{{ $order_id }}</strong></p>
                <div class="flex mt-4">
                    <a class="cta-link px-4 py-3" href="{{ route('home.account') }}">Go to your order</a>
                    <div class="mx-4"></div>
                    <a class="cta-link px-4 py-3" href="{{ route('home') }}">Continue Shopping</a>
                </div>
            </div>
        </section>
    @else
        <section class="w-full md:w-2/3 mx-auto my-8 relative">
            <h2 class="text-center text-2xl font-semibold tracking-wider">Something Went Wrong</h2>
            <div class="flex flex-col items-center">
                <img src="/images/fitting_piece.svg" alt="Order confirmed." class="w-96 h-auto my-4" />
                <p class="text-xl text-slate-700">{{ $error_message }}</p>
                <div class="flex mt-4">
                    <a class="cta-link px-4 py-3" href="{{ route('home.cart') }}">Go to your cart</a>
                </div>
            </div>
        </section>
        @endif
    @endsection
