<div class="w-full md:w-4/5 mx-auto my-4">
    <h2 class="text-center text-xl font-semibold">Cart</h2>
    @if (Cart::isEmpty())
        <div class="my-24 flex flex-col items-center justify-center">
            <p class="mb-4 text-xl">Your cart is empty.</p>
            <a href="{{ route('home') }}" class="cta-link px-8 py-3">Shop Our Products</a>
        </div>
    @else
        <div class="flex flex-col my-8">
            <div class="flex border-b items-center justify-between">
                <div class="py-2 basis-3/5">Product</div>
                <div class="py-2 basis-1/5">Quantity</div>
                <div class="py-2 basis-1/5">Price</div>
            </div>
            @foreach (Cart::getContent() as $item)
                <div class="flex items-center justify-between py-4">
                    <div class="py-2 basis-3/5 flex items-center">
                        <img src="{{ $item->model->media[0]->original_url }}" alt=""
                            class="w-36 h-36 object-cover" />
                        <div class="flex flex-col ms-4">
                            <p class="text-xl">{{ $item->name }}</p>
                            <p class="text-gray-500">{{ $item->attributes['display_name'] }}</p>
                            <p class="text-gray-500">Rs. {{ $item->attributes['selected_variant']['amount'] }}</p>
                        </div>
                    </div>
                    <div class="py-2 basis-1/5">
                        <div class="border w-24 flex items-center p-2 text-gray-600">
                            <button wire:click="reduce_quantity({{ $item['id'] }})">
                                <x-icons.minus />
                            </button>
                            <div class="flex-1 text-center">{{ $item->quantity }}</div>
                            <button wire:click="increase_quantity({{ $item['id'] }})">
                                <x-icons.plus />
                            </button>
                        </div>
                        <button class="underline mt-2 w-24 text-center"
                            wire:click="remove_item({{ $item['id'] }})">Remove</button>
                    </div>
                    <div class="py-2 basis-1/5">Rs. {{ number_format($item->getPriceSum(), 2) }}</div>
                </div>
            @endforeach
            <div class="flex items-center border-t py-4">
                {{-- <div class="flex flex-col basis-3/5 pe-4">
                    <p>Add Note</p>
                    <div class="">
                        <textarea name="note" id="note" cols="30" rows="3"></textarea>
                    </div>
            </div> --}}
                <div class="flex basis-4/5"></div>
                <div class="flex flex-col basis-1/5">
                    <p class="text-2xl mb-2">Total: Rs. {{ number_format(Cart::getTotal(), 2) }}</p>
                    <a href="{{ route('home.checkout') }}" class="cta-link py-3 px-4 text-center">Checkout</a>
                </div>
            </div>
        </div>
    @endif

</div>
