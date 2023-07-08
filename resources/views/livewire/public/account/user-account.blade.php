<div class="w-full md:w-11/12 p-4 mx-auto my-8">
    <div class="flex flex-col items-center justify-center">
        <h2 class="tracking-widest my-4 text-2xl text-slate-600 font-semibold">My Account</h2>
        <p>Welcome, {{ auth()->user()->name }}</p>
    </div>
    <div class="flex flex-row mt-8">
        <div class="flex flex-col flex-1">
            <h3 class="w-full pb-4 border-b text-slate-500 text-md mb-4 font-semibold">My Orders</h3>
            @forelse ($orders as $order)
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
        <h3 class="mt-4 w-full pb-4 border-b text-slate-500 text-md mb-4 font-semibold">Logout</h3>
        <p>Want to Logout and continue as guest?</p>
        <button class="px-4 py-3 border border-red-500 text-red-500 font-semibold mt-4">Logout</button>
    </div>
</div>
</div>
