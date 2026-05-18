<x-default-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold mb-6">Edit Status Pesanan: {{ $order->order_number }}</h2>
        
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="payment_status" id="payment_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <div class="flex items-center gap-4 border-t pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900 hover:underline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>