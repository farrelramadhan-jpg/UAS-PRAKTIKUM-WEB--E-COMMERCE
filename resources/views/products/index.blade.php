<x-default-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Belanja Produk Terbaik</h1>
                <p class="text-lg text-blue-100 mb-8">Temukan ribuan produk berkualitas dengan harga terjangkau</p>
                <form class="flex max-w-md mx-auto gap-2">
                    <input 
                        type="text" 
                        placeholder="Cari produk..." 
                        class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-lg font-semibold">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <section class="bg-white border-b border-gray-200 sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex gap-4 overflow-x-auto pb-2">
                <a href="{{ route('products.public.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-full {{ !request('category') ? 'bg-blue-100 text-blue-600 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} whitespace-nowrap">
                    <i class="ph ph-list"></i> Semua Produk
                </a>
                @foreach($categories as $category)
                <a href="{{ route('products.public.index', ['category' => $category->id]) }}" class="flex items-center gap-2 px-4 py-2 rounded-full {{ request('category') == $category->id ? 'bg-blue-100 text-blue-600 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} whitespace-nowrap">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-r from-orange-500 to-pink-500 rounded-lg p-8 text-white">
                <h2 class="text-2xl font-bold mb-2">Flash Sale</h2>
                <p class="text-sm mb-4">Hemat hingga 50%</p>
                <button class="bg-white text-orange-500 font-semibold px-6 py-2 rounded-lg hover:bg-gray-100">
                    Lihat Penawaran
                </button>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-lg p-8 text-white">
                <h2 class="text-2xl font-bold mb-2">Produk Terbaru</h2>
                <p class="text-sm mb-4">Koleksi terbaru minggu ini</p>
                <button class="bg-white text-green-500 font-semibold px-6 py-2 rounded-lg hover:bg-gray-100">
                    Jelajahi
                </button>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Produk Pilihan</h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                    <i class="ph ph-sort-ascending"></i>
                </button>
                <select class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Terbaru</option>
                    <option>Harga: Terendah</option>
                    <option>Harga: Tertinggi</option>
                    <option>Rating</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                    <!-- Image -->
                    <div class="relative bg-gray-200 h-48 overflow-hidden">
                        @if($product->main_image)
                            <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://picsum.photos/seed/{{ $product->id }}/400/400" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @endif
                        <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="bg-white rounded-full p-2 hover:bg-gray-100 shadow transition group/btn">
                                @php
                                    $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                                @endphp
                                @if($inWishlist)
                                <i class="ph-fill ph-heart text-xl text-red-500"></i>
                                @else
                                <i class="ph ph-heart text-xl text-gray-600 group-hover/btn:text-red-500"></i>
                                @endif
                            </button>
                        </form>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-3 opacity-0 group-hover:opacity-100 transition">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 shadow-lg">
                                    <i class="ph ph-shopping-cart"></i> Beli
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <!-- Badge -->
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </span>
                        </div>

                        <!-- Product Name -->
                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-2" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>

                        <!-- Rating -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="ph ph-star-fill text-sm"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">(0 ulasan)</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <div class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @if($product->cost_price && $product->cost_price > $product->price)
                            <div class="text-sm text-gray-500 line-through">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</div>
                            @else
                            <div class="text-sm text-transparent line-through select-none">&nbsp;</div>
                            @endif
                        </div>

                        <!-- View Detail -->
                        <a href="{{ route('products.public.show', $product->id) }}" class="block text-center text-blue-600 font-semibold text-sm hover:text-blue-700">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <!-- Pagination -->
        <div class="flex justify-center mt-12 w-full">
            {{ $products->links() }}
        </div>
    </section>
</x-default-layout>
