@section('section')
@if (session('success'))  	
	<div id="closealert" class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
	  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
		<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
	  </svg>	 
	  <div class="px-2">
		<span class="font-medium">{{ session('success') }}</span>
	  </div>
	</div>
@endif

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
						<th class="border-b p-4 text-slate-800 text-left font-medium">Status</th>
						<th class="border-b p-4 text-slate-800 text-left font-medium">Action</th>
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
							<td class="p-4">
                                @foreach ($order->order_items as $item)
                                    <div class="flex flex-col mb-4">                                       
                                         <p>{{ $item->statuses[0]->status->status }}</p>
                                    </div>
                                @endforeach
                            </td>
							<td class="p-4">						
								@php $orderId =  '' @endphp
								@foreach ($order->order_items as $item)
									@php $orderId = $item->statuses[0]->order_item_id @endphp	
									<form action="{{ route('admin.order.updateOrderStatus') }}" method="post">
									@csrf
									<div class="mb-4">
										<label for="status" class="block text-sm font-medium text-gray-700"></label>										
											
										<select id="status" name="status" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
											@foreach ($statuses as $status)	
												<option value="{{ $status->id }}">{{ $status->status }}</option>
											@endforeach	
										</select>										
										<input type="hidden" id="order_id" name="order_id" value="{{$orderId}}">									
									</div>

									<div class="flex items-center">
										<button type="submit" class="inline-block bg-green-600 text-white px-4 py-2 rounded">Update Status</button>
									</div>
								</form>									
								@endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $orders->links() }}
@endsection
