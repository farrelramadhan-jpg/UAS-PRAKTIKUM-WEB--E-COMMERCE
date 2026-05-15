<x-default-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
            <p class="text-gray-600 mt-2">Nomor pesanan Anda <strong>{{ $order->order_number }}</strong></p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan</h2>
                    <div class="space-y-3 text-sm text-gray-700">
                        <p><span class="font-semibold">Status:</span> {{ ucfirst($order->status) }}</p>
                        <p><span class="font-semibold">Status Pembayaran:</span> {{ ucfirst($order->payment_status) }}</p>
                        <p><span class="font-semibold">Tipe Pengiriman:</span> {{ ucfirst($order->shipping_type) }}</p>
                        <p><span class="font-semibold">Metode Pembayaran:</span> {{ ucfirst($order->payment_method) }}</p>
                        <p><span class="font-semibold">Catatan:</span> {{ $order->notes ?? '-' }}</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Rincian Produk</h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">{{ $item->product_name }}</div>
                                    <div class="text-sm text-gray-500">SKU {{ $item->product_sku }}</div>
                                </div>
                                <div class="text-sm text-gray-700">{{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                                <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h2>
                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Pengiriman</span>
                            <span>Rp {{ number_format($order->shipping_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon</span>
                            <span>Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-semibold text-gray-900 border-t border-gray-200 pt-3">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Data Pelanggan</h2>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Nama:</span> {{ $order->user->name }}</p>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Email:</span> {{ $order->user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
