<div class="flex flex-col p-4">
    <h2 class="text-center text-2xl tracking-widest mb-4 text-slate-600">Add New Address</h2>
    <p class="text-sm text-gray-600 mb-4">Please fill in the information below:</p>
    <form wire:submit.prevent="save_address">
        <div class="flex flex-col mb-4">
            <input type="text" name="person_name" placeholder="Contact person name" wire:model.defer="address.name" />
            @error('address.name')
                <span class="error">Please enter the name.</span>
            @enderror
        </div>
        <div class="flex flex-col mb-4">
            <input type="tel" name="mobile" placeholder="Mobile number" maxlength="10"
                wire:model.defer="address.mobile" />
            @error('address.mobile')
                <span class="error">Please enter the mobile.</span>
            @enderror
        </div>
        <div class="flex flex-col mb-4">
            <input type="text" name="address_line1" placeholder="Address line 1"
                wire:model.defer="address.address_line1" />
            @error('address.address_line1')
                <span class="error">Please enter the address line.</span>
            @enderror
        </div>
        <div class="flex flex-col mb-4">
            <input type="text" name="address_line1" placeholder="Address line 2"
                wire:model.defer="address.address_line2" />
        </div>
        <div class="flex flex-col mb-4">
            <input type="text" name="landmark" placeholder="Landmark" wire:model.defer="address.landmark" />
        </div>
        <div class="flex mb-4 w-full">
            <div class="flex flex-col flex-1">
                <input type="text" name="city" placeholder="City" wire:model.defer="address.city" />
                @error('address.city')
                    <span class="error">Please enter the address line.</span>
                @enderror
            </div>
            <div class="mx-2"></div>
            <div class="flex flex-col flex-1">
                <input type="tel" name="pincode" placeholder="Pincode" maxlength="6"
                    wire:model.defer="address.pincode" />
                @error('address.pincode')
                    <span class="error">Please enter the pincode.</span>
                @enderror
            </div>
        </div>
        <div class="flex flex-col mb-4">
            <select name="state" id="state" wire:model.defer="address.state_id">
                <option value="">Select the state</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
            @error('address.state_id')
                <span class="error">Please enter the address line.</span>
            @enderror
        </div>
        <div class="flex items-center mb-4">
            <input type="checkbox" name="is_default" id="is_default" class="me-4" wire:model="address.is_default">
            <label for="is_default">Set as default address</label>
        </div>
        <button class="cta-link py-3 w-full">Add Address</button>
    </form>
</div>
