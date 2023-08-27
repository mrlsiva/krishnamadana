@section('section')
    <div class="section-header mb-4">
        Orders List
    </div>
    <div class="rounded-xl relative overflow-auto">
        <div class="shadow-sm overflow-hidden">
            <table class="w-full table-auto border-collapse bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Order &amp; Payment ID</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Items</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Amount and Discount</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Order Date</th>
                        <th class="border-b p-4 text-slate-800 text-left font-medium">Shipping Address</th>
                    </tr>
                </thead>
                <tbody>
                    @empty($orders->count())
                        <x-admin.no-results-table colspan="6" />
                    @endempty
                    @foreach ($orders as $order)
                        <tr>
                            <td class="p-4">{{ $loop->iteration }}.</td>
                            <td class="p-4">{{ $order->order_id }}<br/>{{ $order->payment_id }}</td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                @foreach ($order->order_items as $item)
                                    <div class="flex flex-col mb-4">
                                        <p><strong>{{ $item->product->name }}</strong></p>
                                        <p>{{ $item->variant_name }}</p>
                                    </div>
                                @endforeach
                            </div>
                            </td>
                            <td class="p-4">
                                Net Amount: {{ $order->amount }}<br/>
                                Discount: {{ $order->discount }}
                            </td>
                            <td class="p-4">
                                {{ $order->created_at->format('j F, Y') }}
                            </td>
                            <td class="p-4">
                                <div class=""><strong>{{ $order->shipping_address->name }}</strong>,
                                    <br/>{{ $order->shipping_address->address_line1 }},<br/>
                                    @if($order->shipping_address->address_line2)
                                    {{ $order->shipping_address->address_line2 }},<br/>
                                    @endif
                                    @if ($order->shipping_address->landmark)
                                    {{ $order->shipping_address->landmark }},
                                    <br/>
                                    @endif
                                    {{ $order->shipping_address->city }},
                                    <br/>{{ $order->shipping_address->state->name }}, {{ $order->shipping_address->pincode }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $orders->links() }}
@endsection
