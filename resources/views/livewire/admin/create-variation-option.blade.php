<div class="flex flex-col">
    <div class="section-header">
        Variations Options List
    </div>
    <div class="flex flex-wrap items-baseline my-4">
        <div class="flex flex-col flex-1 me-5">
            <select name="variation_id" id="variation_id" class="peer input" wire:model="variation_id">
                <option value="">Select a variation</option>
                @foreach ($variations as $variation)
                    <option value="{{ $variation->id }}">{{ $variation->name }}</option>
                @endforeach()
            </select>
            @error('variation_id')
                <div class="error basis-full">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col flex-1 me-5">
            <input type="text" class="flex-1 peer input" placeholder="Enter new variation name..."
                wire:model="value">
            @error('value')
                <div class="error basis-full">{{ $message }}</div>
            @enderror
        </div>
        <button wire:click="add_option" class="inline-block bg-green-600 text-white px-4 py-2 rounded">Add
            Option</button>

    </div>


    <div class="rounded-xl relative overflow-auto">
        <div class="shadow-sm overflow-hidden">
            <table class="w-full table-auto border-collapse bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Variation Name</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Option</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @empty($options->count())
                        <x-admin.no-results-table colspan="7" />
                    @endempty
                    @foreach ($options as $option)
                        <tr>
                            <td class="p-4">{{ $loop->iteration }}.</td>
                            <td class="p-4">{{ $option->variation->name }}</td>
                            <td class="p-4">{{ $option->value }}</td>
                            <td class="p-4">
                                <div class="flex">
                                    <button class="inline-block w-8 h-8 bg-blue-600 text-white p-2 rounded mr-5">
                                        <x-icons.edit />
                                    </button>
                                    <button wire:click="confirm_delete({{ $option->id }})"
                                        class="w-8 h-8 bg-red-600 text-white p-2 rounded">
                                        <x-icons.delete />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
