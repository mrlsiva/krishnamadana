<div>
    <div class="section-header">
        Category List
    </div>
    <a href="{{ route('admin.createCategory') }}" class="inline-block my-4 bg-green-600 text-white px-4 py-2 rounded">Add
        Category</a>
    <div class="rounded-xl relative overflow-auto">
        <div class="shadow-sm overflow-hidden">
            <table class="w-full table-auto border-collapse bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Image</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Category</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Order</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @empty($categories->count())
                        <x-admin.no-results-table colspan="5" />
                    @endempty
                    @foreach ($categories as $category)
                        <tr>
                            <td class="p-4">{{ $loop->iteration }}.</td>
                            <td class="p-4"><img src="{{ $category->media[0]->original_url }}" alt=""
                                    class="w-24 h-24 rounded-full object-cover"></td>
                            <td class="p-4">{{ $category->name }}</td>
                            <td class="p-4">{{ $category->order }}</td>
                            <td class="p-4">
                                <button class="w-8 h-8 bg-blue-600 text-white p-2 rounded mr-5">
                                    <x-icons.edit />
                                </button>
                                <button class="w-8 h-8 bg-red-600 text-white p-2 rounded">
                                    <x-icons.delete />
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
