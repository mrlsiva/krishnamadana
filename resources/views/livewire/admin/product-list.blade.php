@section('section')
    <div class="section-header">
        Product List
    </div>
    <a href="{{ route('admin.store.createProduct') }}" class="inline-block my-4 bg-green-600 text-white px-4 py-2 rounded">Add
        Product</a>
    <div class="rounded-xl relative overflow-auto">
        <div class="shadow-sm overflow-hidden">
            <table class="w-full table-auto border-collapse bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
						<th class="border-b p-4 text-slate-800 text-left font-medium">Thumb</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Product</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Stock</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Price</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Orders</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Rating</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @empty($products->count())
                        <x-admin.no-results-table colspan="7" />
                    @endempty
                    @foreach ($products as $product)
                        <tr>
                            <td class="p-4">{{ $loop->iteration }}.</td>
							<td class="p-4">
							@foreach ($product->media->slice(0, 2) as $image)                                                   
								@if ($loop->first)
								<img src="{{ $image->original_url }}"
									class="@if ($loop->first) front-image @else back-image @endif"
									alt="{{ $product->name }}" width="80" height="80">
								@endif
							@endforeach</td>
                            <td class="p-4">{{ $product->name }}</td>

                            </td>
                            <td class="p-4">14</td>
                            <td class="p-4">Rs. 200</td>
                            <td class="p-4">10</td>
                            <td class="p-4">5</td>
                            <td class="p-4">
                                <div class="flex">
                                    <a href="{{ route('admin.store.editProduct', ['product' => $product]) }}"
                                        class="inline-block w-8 h-8 bg-blue-600 text-white p-2 rounded mr-5">
                                        <x-icons.edit />
                                    </a>
                                    <button class="w-8 h-8 bg-red-600 text-white p-2 rounded">
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
@endsection
