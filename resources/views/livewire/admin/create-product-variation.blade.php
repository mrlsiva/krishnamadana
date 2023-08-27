    <div class="flex flex-col">
        <div class="section-header">
            Product Variations List
        </div>
        <div class="flex flex-wrap my-4">
            <input type="text" class="flex-1 peer input me-5" placeholder="Enter new variation name..."
                wire:model="name">
            <button wire:click="add_variation" class="inline-block bg-green-600 text-white px-4 py-2 rounded">Add
                Product Variation</button>
            @error('name')
                <div class="error basis-full">{{ $message }}</div>
            @enderror
        </div>


        <div class="rounded-xl relative overflow-auto">
            <div class="shadow-sm overflow-hidden">
                <table class="w-full table-auto border-collapse bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Variation Name</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @empty($variations->count())
                            <x-admin.no-results-table colspan="7" />
                        @endempty
                        @foreach ($variations as $variation)
                            <tr>
                                <td class="p-4">{{ $loop->iteration }}.</td>
                                <td class="p-4">{{ $variation->name }}</td>
                                <td class="p-4">
                                    <div class="flex">
                                        <button class="inline-block w-8 h-8 bg-blue-600 text-white p-2 rounded mr-5">
                                            <x-icons.edit />
                                        </button>
                                        <button wire:click="confirm_delete({{ $variation->id }})"
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
