<div class="flex w-full md:w-10/12 mx-auto p-8">
    <div class="flex flex-col basis-3/5 me-8">
        <h2 class="tracking-widest text-lg border-b pb-2 mb-4">Shipping Address</h2>

        @foreach ($addresses as $address)
            <div class="flex border p-4 mb-4 cursor-pointer select-none @if ($selected == $address->id) border-green-600 bg-green-100 @else border-gray-500 @endif"
                wire:click="select_address({{ $address->id }})">
                <input type="radio" class="me-5 mt-1 text-green-800" @checked($selected == $address->id) />
                <div class=""><strong>{{ $address->name }}</strong>, {{ $address->address_line1 }},
                    {{ $address->address_line2 }},
                    {{ $address->landmark }}, {{ $address->city }}, {{ $address->state->name }}, {{ $address->pincode }}
                </div>
            </div>
        @endforeach

        <a href="javascript:void(0)" class="flex items-center justify-center mt-5" wire:click="open_address_modal">
            <x-icons.plus /> Add New Address
        </a>
    </div>
    <div class="basis-2/5 flex flex-col">
        @foreach (Cart::getContent() as $item)
            <div class="flex items-center">
                <div class="relative">
                    <img src="{{ $item->model->media[0]->original_url }}" alt=""
                        class="w-24 h-24 object-cover rounded" />
                    <div class="absolute -top-4 -right-4 bg-gray-600 rounded px-2 py-1 text-white text-sm">
                        {{ $item->quantity }}
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-center ml-5">
                    <p class="text-base">{{ $item->name }}</p>
                    <p class="text-gray-500">{{ $item->attributes['display_name'] }}</p>
                </div>
                <div class="">Rs. {{ number_format($item->getPriceSum(), 2) }}</div>
            </div>
        @endforeach
        <div class="flex my-5">
            <div class="flex-1 me-5">
                <input type="text" placeholder="Enter coupon code..."
                    class="peer input w-full border-gray-500 rounded" />
            </div>
            <button class="px-4 bg-yellow-500 rounded text-white">Apply</button>
        </div>
        <div class="flex flex-col tracking-wider">
            <div class="flex justify-evenly mb-2">
                <div class="flex-1">Subtotal</div>
                <div class="text-right flex-1">Rs. {{ number_format(Cart::getSubTotal(), 2) }}</div>
            </div>
            <div class="flex justify-evenly mb-2">
                <div class="flex-1">Shipping Charges</div>
                <div class="text-right flex-1">Rs. {{ number_format(Cart::getTotal() - Cart::getSubTotal(), 2) }}</div>
            </div>
            <div class="flex justify-evenly text-lg">
                <div class="flex-1">Total</div>
                <div class="text-right flex-1">Rs. {{ number_format(Cart::getTotal(), 2) }}</div>
            </div>
            <div class="mt-4">
                <textarea name="note" id="note" rows="3" class="w-full resize-none"
                    placeholder="Add any notes for your delivery and order..." wire:model.defer="notes"></textarea>
            </div>
        </div>
        <button class="mt-4 cta-link py-3" wire:click="continue_checkout">Continue Payment</button>
        {{-- <form id="checkout" action="{{ route('home') }}">
            @csrf
            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ config('app.razorpay_keyid') }}"
                data-amount="{{ Cart::getTotal() * 100 }}" data-buttontext="Pay {{ Cart::getTotal() }} INR"
                data-name="{{ config('app.name') }}" data-description="Product checkout" data-image="/images/logo-icon.png"
                data-prefill.name="{{ auth()->user()->name }}" data-prefill.email="{{ auth()->user()->email }}"
                data-prefill.contact="{{ auth()->user()->mobile }}" data-theme.color="#ff7529"></script>
        </form> --}}
    </div>
</div>

@section('scripts')
    <script>
        Livewire.on('openCheckout', function(options) {
            var checkout = new Razorpay(options);
            checkout.open();
        });
    </script>
@endsection
