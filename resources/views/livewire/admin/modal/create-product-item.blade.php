<div class="w-full flex flex-col mx-auto p-4">
    <h1 class="text-center font-bold text-lg text-slate-600">Select Product Variations</h1>
    <div class="">SKU: <strong>{{ $item->sku }}</strong></div>
    <p><span class="text-red-500">*</span> are required fields</p>
    <form wire:submit.prevent="create_sku">
        @foreach ($variants as $variant)
            <p class="text-xl"><strong>{{ $variant->name }}</strong></p>
            @foreach ($variant->options as $option)
                <p class="my-2"><label class="me-2"><input type="radio" name="{{ $variant->name }}"
                            value="{{ $option->id }}" data-variation-id="{{ $variant->id }}"
                            wire:model="selected_variants.{{ $option->id }}">
                        {{ $option->value }}</label></p>
            @endforeach
        @endforeach
        <div class="flex items-center justify-between mt-4">
            <label class="basis-16 text-right font-bold mr-4">Price<span class="text-red-500">*</span></label>
            <input type="text" placeholder="Enter the SKU price" class="flex-1 peer input"
                wire:model="item.amount" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <label for="" class="basis-16 text-right font-bold mr-4">Stock</label>
            <div class="flex flex-col flex-1">
                <input type="text" placeholder="Enter the stock count" class="flex-1 peer input"
                    wire:model="item.stock" />
                <span class="text-sm text-gray-600">Leave blank if you don't want to maintain stock</span>
            </div>
        </div>
        <div class="flex items-center justify-center mt-4">
            <button class="bg-orange-500 px-4 py-2 rounded text-white">Select Variation</button>
        </div>
    </form>
    {{-- <form wire:submit.prevent="create_sku">
        <div class="flex items-center justify-between mt-4">
            <label class="basis-16 text-right font-bold mr-4">Price<span class="text-red-500">*</span></label>
            <input type="text" placeholder="Enter the SKU price" class="flex-1 peer input"
                wire:model="item.amount" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <label for="" class="basis-16 text-right font-bold mr-4">Stock</label>
            <div class="flex flex-col flex-1">
                <input type="text" placeholder="Enter the stock count" class="flex-1 peer input"
                    wire:model="item.stock" />
                <span class="text-sm text-gray-600">Leave blank if you don't want to maintain stock</span>
            </div>
        </div>

        @foreach ($options as $index => $variant)
            <div class="flex items-center justify-between mt-4">
                <label for="" class="basis-16 text-right font-bold mr-4">{{ $variant['name'] }}</label>
                <input type="text" placeholder="Enter the {{ $variant['name'] }} value" class="flex-1 peer input"
                    wire:model="options.{{ $index }}.value" />
            </div>
        @endforeach
        <div class="flex mt-4 items-center justify-center">
            @foreach ($available_variants as $variant)
                <button type="button" wire:click="add_option('{{ $variant }}')"
                    class="me-4 text-blue-500 underline">Add
                    {{ $variant }}</button>
            @endforeach
        </div>

        <div class="flex items-center justify-center mt-4">
            <button class="bg-orange-500 px-4 py-2 rounded text-white">Add
                SKU</button>
        </div>
    </form> --}}
</div>
