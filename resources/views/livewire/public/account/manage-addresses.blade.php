<div class="w-full md:w-11/12 p-4 mx-auto my-8">
    <a href="{{ route('home.account') }}" class="flex items-center">
        <x-icons.chevron-left />
        Back to Account
    </a>
    <div class="flex flex-col items-center justify-center">
        <h2 class="tracking-widest my-4 text-2xl text-slate-600">My Addresses</h2>
        <div class="grid grid-cols-3 gap-4">
            @forelse ($addresses as $address)
                <div class="p-4 tracking-wider">
                    <h3 class="border-b pb-2 mb-4 font-semibold">
                        @if ($address->is_default)
                            Primary Address
                        @else
                            Address {{ $loop->iteration }}
                        @endif
                    </h3>
                    <p class="text-xl mb-2">{{ $address->name }}</p>
                    <p class="leading-6">Contact No: {{ $address->mobile }}</p>
                    <p class="leading-6">{{ $address->address_line1 }}</p>
                    <p class="leading-6">{{ $address->address_line2 }}</p>
                    <p class="leading-6">{{ $address->landmark }}</p>
                    <p class="leading-6">{{ $address->city }}, {{ $address->pincode }}</p>
                    <p class="leading-6">{{ $address->state->name }}</p>
                    <div class="flex mt-2">
                        <button class="underline me-4 text-slate-900 text-lg"
                            wire:click="open_address_modal({{ $address->id }})">Edit</button>
                        <button class="underline text-red-500 text-lg"
                            wire:click="show_confirm_alert({{ $address->id }})">Delete</button>
                    </div>
                </div>
            @empty
                <p>No addresses were saved yet.</p>
                <button class="cta-link mt-4 px-8 py-3" wire:click="open_address_modal">Add New Address</button>
            @endforelse
        </div>


    </div>

</div>
