<div>
	<form wire:submit.prevent="updateStatus">
		<div class="mb-4">
			<label for="status" class="block text-sm font-medium text-gray-700"></label>
			<select id="status" wire:model="status" name="status" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
				<option value="1">Order Received</option>
				<option value="2">Order Confirmed</option>
				<option value="3">Order Dispatched</option>
				<option value="4">Delivered</option>
				<option value="5">Cancelled</option>
				<option value="6">Return Pickup</option>
				<option value="7">Returned</option>
				<option value="8">Refund Initiated</option>
				<option value="9">Refund Credited</option>
			</select>
			
		<input type="hidden" id="order_id" wire:model="order_id" name="order_id" value="">
		
		</div>

		<div class="flex items-center">
			<button type="submit" class="bg-blue-500 text-dark px-4 py-2 rounded">Update Status</button>
		</div>
	</form>
<div>
