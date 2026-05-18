<x-default-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold mb-4">Detail Pesanan: {{ $order->order_number }}</h2>
        
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-lg border-b pb-2 mb-4">Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> {{ $order->user->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold text-lg border-b pb-2 mb-4">Item Pesanan</h3>
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="py-2">Produk</th>
                        <th class="py-2">Harga</th>
                        <th class="py-2">Kuantitas</th>
                        <th class="py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="py-2">{{ $item->product_name }}</td>
                        <td class="py-2">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="py-2">{{ $item->quantity }}</td>
                        <td class="py-2">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <<div class="mt-4">
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 font-semibold transition">
                ← Kembali ke Daftar Kategori
            </a>
        </div>
    </div>
</x-default-layout>