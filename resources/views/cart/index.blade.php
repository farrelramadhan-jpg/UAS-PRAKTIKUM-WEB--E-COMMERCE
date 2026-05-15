<x-default-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($carts->isEmpty())
            <div class="text-center py-16 bg-white rounded-lg shadow">
                <i class="ph ph-shopping-cart text-6xl text-gray-400 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
                <p class="text-gray-500 mb-6">Mulai pilih barang-barang menarik dari toko kami!</p>
                <a href="{{ route('products.public.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @php $total = 0; @endphp
                    @foreach($carts as $cart)
                        @php $subtotal = $cart->product->price * $cart->quantity; $total += $subtotal; @endphp
                        <div class="bg-white rounded-lg shadow p-4 flex gap-4 items-center">
                            <div class="w-24 h-24 bg-gray-200 rounded-md overflow-hidden shrink-0">
                                @if($cart->product->main_image)
                                    <img src="{{ Storage::url($cart->product->main_image) }}" alt="{{ $cart->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://picsum.photos/seed/{{ $cart->product->id }}/200/200" alt="{{ $cart->product->name }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 line-clamp-2">
                                    <a href="{{ route('products.public.show', $cart->product->id) }}">{{ $cart->product->name }}</a>
                                </h3>
                                <p class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-3">
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                                <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" class="w-16 px-2 py-1 border border-gray-300 rounded text-center" onchange="this.form.submit()">
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="bg-white rounded-lg shadow p-6 h-fit sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 pb-4 border-b">Ringkasan Belanja</h2>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Total Harga ({{ $carts->sum('quantity') }} barang)</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-6 pb-6 border-b">
                        <span class="text-gray-600">Diskon</span>
                        <span class="font-semibold text-green-600">- Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-6">
                        <span class="text-lg font-bold text-gray-900">Total Tagihan</span>
                        <span class="text-xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                        Beli Sekarang ({{ $carts->sum('quantity') }})
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-default-layout>
