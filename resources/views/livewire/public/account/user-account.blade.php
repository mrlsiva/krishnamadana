<div class="w-full md:w-11/12 p-4 mx-auto my-8">
    <div class="flex flex-col items-center justify-center">
        <h2 class="tracking-widest my-4 text-2xl text-slate-600 font-semibold">My Account</h2>
        <p>Welcome, {{ auth()->user()->name }}</p>
    </div>
    <div class="flex flex-row mt-8">
        <div class="flex flex-col flex-1">
            <h3 class="w-full pb-4 border-b text-slate-500 text-md mb-4 font-semibold">My Orders</h3>
            @forelse ($orders as $order)
                <div class="flex flex-col border rounded">
                    <div class="bg-gray-300 flex items-center justify-between p-4 border-b tracking-wider">
                        <div class="flex flex-col">
                            <p class="text-sm uppercase">Order Id</p>
                            <p>{{ Str::replace('order_', '', $order->order_id) }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm uppercase">Order Placed</p>
                            <p>{{ $order->created_at->format('j F, Y') }}</p>
                        </div>
                        <div class="flex flex-col" x-data="{ tooltip: false }">
                            <p class="text-sm uppercase">Ship To</p>
                            <div class="relative cursor-pointer" x-on:mouseover="tooltip = true"
                                x-on:mouseleave="tooltip = false">
                                <div class="flex text-blue-900">{{ $order->shipping_address->name }}
                                    <x-icons.chevron-down />
                                </div>
                                <div x-show="tooltip"
                                    class="text-sm absolute bg-white rounded-lg p-2
                                transform shadow-lg w-48 -translate-x-8 translate-y-1">
                                    <p>{{ $order->shipping_address->name }},</p>
                                    <p class="leading-6">{{ $order->shipping_address->address_line1 }},</p>
                                    @if ($order->shipping_address->address_line2)
                                        <p class="leading-6">{{ $order->shipping_address->address_line2 }},</p>
                                    @endif
                                    @if ($order->shipping_address->landmark)
                                        <p class="leading-6">{{ $order->shipping_address->landmark }}</p>
                                    @endif
                                    <p class="leading-6">{{ $order->shipping_address->city }},
                                        {{ $order->shipping_address->pincode }}</p>
                                    <p class="leading-6">{{ $order->shipping_address->state->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        @foreach ($order->order_items as $item)
                            <div class="flex flex-col w-full">
                                <p class="px-4 pt-2 text-lg font-bold">{{ $item->statuses->last()->status->status }}
                                </p>
                                <div class="flex p-4 w-full">
                                    <img src="{{ $item->product->media[0]->original_url }}"
                                        alt="{{ $item->product->name }}" class="w-24 h-auto object-cover rounded">
                                    <div class="flex flex-col ms-4 justify-center flex-1">
                                        <p><a href="{{ route('home.product-details', ['slug' => $item->product->slug]) }}"
                                                class="text-blue-600 tracking-wider text-md">{{ $item->product->name }}</a>
                                        </p>
                                        <p>{{ $item->variant_name }}</p>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <button class="border px-4 py-2 rounded shadow text-sm">Track Package</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p>You have not placed any orders yet.</p>
            @endforelse

        </div>
        <div class="w-12 mx-4"></div>
        <div class="flex flex-col basis-1/3">
            <h3 class="w-full pb-4 border-b text-slate-500 text-md mb-4 font-semibold">My Addresses</h3>

        @empty($primary_address)
            <p>No addresses are saved.</p>
        @else
            <p class="text-xl mb-2">{{ $primary_address->name }}</p>
            <p class="leading-6">Contact No: {{ $primary_address->mobile }}</p>
            <p class="leading-6">{{ $primary_address->address_line1 }}</p>
            <p class="leading-6">{{ $primary_address->address_line2 }}</p>
            <p class="leading-6">{{ $primary_address->landmark }}</p>
            <p class="leading-6">{{ $primary_address->city }}, {{ $primary_address->pincode }}</p>
            <p class="leading-6">{{ $primary_address->state->name }}</p>
            @if ($address_count > 0)
                <p class="mt-2 text-gray-500">and {{ $address_count }} other
                    {{ Str::plural('address', $address_count) }}.</p>
            @endif
        @endempty


        <a class="cta-link px-4 py-3 mt-4" href="{{ route('home.manage-addresses') }}">Manage Addresses</a>
        <h3 class="mt-8 w-full pb-4 border-b text-slate-500 text-md mb-4 font-semibold">Logout</h3>
        <p>Want to Logout and continue as guest?</p>
        <button class="px-4 py-3 border border-red-500 text-red-500 font-semibold mt-4"
            wire:click="logout">Logout</button>
    </div>
</div>
</div>
