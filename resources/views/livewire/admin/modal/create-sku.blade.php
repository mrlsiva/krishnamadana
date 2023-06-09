<div class="w-full flex flex-col mx-auto p-4">
    <h1 class="text-center font-bold text-lg text-slate-600">Create New SKU</h1>
    <div class="">SKU: <strong>{{ $sku['sku'] }}</strong></div>
    <p><span class="text-red-500">*</span> are required fields</p>
    <form wire:submit.prevent="create_sku">
        @foreach ($variants as $index => $variant)
            <div class="flex items-center justify-between mt-4">
                <label for="" class="basis-16 text-right font-bold mr-4">{{ $variant['name'] }}</label>
                <input type="text" placeholder="Enter the {{ $variant['name'] }} value" class="flex-1 peer input"
                    wire:model="sku.variants.{{ $index }}.value" />
            </div>
        @endforeach
        <div class="flex items-center justify-between mt-4">
            <label for="" class="basis-16 text-right font-bold mr-4">Price <span
                    class="text-red-500">*</span></label>
            <input type="number" placeholder="Enter the SKU price" class="flex-1 peer input" wire:model="sku.amount" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <label for="" class="basis-16 text-right font-bold mr-4">Stock</label>
            <input type="number" placeholder="Enter the stock count" class="flex-1 peer input"
                wire:model="sku.stock" />
        </div>
        <span class="text-sm text-gray-600">Leave blank if you don't want to maintain stock</span>
        <div class="flex items-center justify-center mt-4">
            <button class="bg-orange-500 px-4 py-2 rounded text-white">Add
                SKU</button>
        </div>
    </form>
</div>
