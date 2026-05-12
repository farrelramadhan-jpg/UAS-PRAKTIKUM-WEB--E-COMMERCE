<x-default-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Wishlist Anda</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($wishlists->isEmpty())
            <div class="text-center py-16 bg-white rounded-lg shadow">
                <i class="ph ph-heart text-6xl text-gray-400 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Wishlist Anda Kosong</h2>
                <p class="text-gray-500 mb-6">Temukan barang impian Anda dan simpan di sini!</p>
                <a href="{{ route('products.public.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Cari Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($wishlists as $wishlist)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                        <!-- Image -->
                        <div class="relative bg-gray-200 h-48 overflow-hidden">
                            @if($wishlist->product->main_image)
                                <img src="{{ Storage::url($wishlist->product->main_image) }}" alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://picsum.photos/seed/{{ $wishlist->product->id }}/400/400" alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover">
                            @endif
                            <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                <button type="submit" class="bg-white rounded-full p-2 hover:bg-gray-100 shadow transition" title="Hapus dari Wishlist">
                                    <i class="ph-fill ph-heart text-xl text-red-500"></i>
                                </button>
                            </form>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-3 opacity-0 group-hover:opacity-100 transition">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 shadow-lg">
                                        <i class="ph ph-shopping-cart"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <!-- Badge -->
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $wishlist->product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-2" title="{{ $wishlist->product->name }}">
                                <a href="{{ route('products.public.show', $wishlist->product->id) }}" class="hover:text-blue-600">
                                    {{ $wishlist->product->name }}
                                </a>
                            </h3>

                            <!-- Price -->
                            <div class="mb-3">
                                <div class="text-xl font-bold text-gray-900">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-default-layout>
