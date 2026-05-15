<x-default-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout Pesanan</h1>
            <p class="text-gray-600 mt-2">Lengkapi alamat pengiriman dan pilih tipe pengiriman sebelum mengirim pesanan.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                            <textarea name="shipping_address" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Penagihan</label>
                            <textarea name="billing_address" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('billing_address') }}</textarea>
                            @error('billing_address')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pengiriman</label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer">
                                    <input type="radio" name="shipping_type" value="standard" class="h-4 w-4" {{ old('shipping_type', 'standard') === 'standard' ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-semibold">Standard</div>
                                        <div class="text-sm text-gray-600">Biaya pengiriman standar Rp 15.000</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer">
                                    <input type="radio" name="shipping_type" value="express" class="h-4 w-4" {{ old('shipping_type') === 'express' ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-semibold">Express</div>
                                        <div class="text-sm text-gray-600">Pilihan cepat, biaya pengiriman Rp 30.000</div>
                                    </div>
                                </label>
                            </div>
                            @error('shipping_type')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pesanan</label>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Pesan Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-4">
                        @foreach($carts as $cart)
                            <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                                    @if($cart->product->main_image)
                                        <img src="{{ Storage::url($cart->product->main_image) }}" alt="{{ $cart->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://picsum.photos/seed/{{ $cart->product->id }}/200/200" alt="{{ $cart->product->name }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">{{ $cart->product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $cart->quantity }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="font-semibold text-gray-900">Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4 space-y-3 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya pengiriman</span>
                            <span id="shipping-cost">Rp 15.000</span>
                        </div>
                        <div class="flex justify-between font-semibold text-gray-900">
                            <span>Total estimasi</span>
                            <span id="order-total">Rp {{ number_format($subtotal + 15000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const standardRadio = document.querySelector('input[name="shipping_type"][value="standard"]');
        const expressRadio = document.querySelector('input[name="shipping_type"][value="express"]');
        const shippingCostEl = document.getElementById('shipping-cost');
        const orderTotalEl = document.getElementById('order-total');
        const subtotal = {{ $subtotal }};

        function formatRupiah(value) {
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function updateShippingSummary() {
            const shippingCost = expressRadio.checked ? 30000 : 15000;
            shippingCostEl.textContent = formatRupiah(shippingCost);
            orderTotalEl.textContent = formatRupiah(subtotal + shippingCost);
        }

        standardRadio.addEventListener('change', updateShippingSummary);
        expressRadio.addEventListener('change', updateShippingSummary);
        updateShippingSummary();
    </script>
</x-default-layout>
