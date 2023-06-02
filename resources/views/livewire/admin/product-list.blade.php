@section('section')
    <div class="section-header">
        Product List
    </div>
    <a href="{{ route('admin.createProduct') }}" class="inline-block my-4 bg-green-600 text-white px-4 py-2 rounded">Add
        Product</a>
    <div class="rounded-xl relative overflow-auto">
        <div class="shadow-sm overflow-hidden">
            <table class="w-full table-auto border-collapse bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Product</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Stock</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Price</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Orders</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Rating</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-4">1.</td>
                        <td class="p-4">Product Name</td>
                        <td class="p-4">14</td>
                        <td class="p-4">Rs. 200</td>
                        <td class="p-4">10</td>
                        <td class="p-4">5</td>
                        <td class="p-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
