<div class="w-full flex flex-col mx-auto p-4">
    <h1 class="text-center font-bold text-lg text-slate-600">Select Product Variations</h1>
    @foreach ($variations as $variation)
        <div class="flex flex-col border-b pb-4 mb-4">
            <label class="flex items-center font-bold text-xl">
                <input type="checkbox" class="text-orange-500 me-2" wire:change="onVariantChange({{ $loop->index }})"
                    wire:model="variations.{{ $loop->index }}.selected">
                {{ $variation['name'] }}</label>
            <div class="flex flex-wrap mt-4">
                @foreach ($variation['options'] as $option)
                    <label class="me-4 flex items-center">
                        <input type="checkbox" class="text-orange-500 me-2"
                            wire:model="variations.{{ $loop->parent->index }}.options.{{ $loop->index }}.selected"
                            wire:change="calculate_variations({{ $loop->parent->index }}, {{ $loop->index }})">
                        {{ $option['value'] }}</label>
                @endforeach
            </div>
        </div>
    @endforeach
    @if (!empty($total_possibilities))
        <p class="mb-4">There will be {{ $total_possibilities }} possible variants in total.</p>
    @endif
    <div class="flex flex-col w-full">
        <div class="relative w-full mb-4">
            <label for="baseprice" class="label">Product Base Price</label>
            <input name="baseprice" id="baseprice" type="number" class="peer input"
                placeholder="Enter product base price" wire:model="base_price" />
        </div>
        @error('base_price')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex items-center justify-center mt-4">
        <button class="bg-orange-500 px-4 py-2 rounded text-white" wire:click="submit">Generate Variation</button>
    </div>
</div>
