<x-default-layout>
    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-sm">
        <div class="flex items-center gap-2 text-gray-600">
            <a href="/" class="hover:text-blue-600">Home</a>
            <i class="ph ph-caret-right"></i>
            <a href="/products" class="hover:text-blue-600">Produk</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-gray-900 font-semibold">Detail Produk</span>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div>
                <!-- Main Image -->
                <div class="bg-gray-200 rounded-lg overflow-hidden mb-4 aspect-square flex items-center justify-center">
                    @if($product->main_image)
                        <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://picsum.photos/seed/{{ $product->id }}/800/800" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- Gallery -->
                @if($product->gallery_images)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->gallery_images as $image)
                        <button class="bg-gray-200 rounded-lg aspect-square flex items-center justify-center hover:ring-2 hover:ring-blue-600 transition overflow-hidden">
                            <img src="{{ Storage::url($image) }}" alt="Gallery" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <!-- Category Badge -->
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                    </span>
                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                        <i class="ph ph-check-circle"></i> Terjual 0
                    </span>
                </div>

                <!-- Product Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $product->name }}
                </h1>

                <!-- Rating & Reviews -->
                @php
                    $productRating = $product->average_rating ?: 0;
                    $productReviews = $product->total_reviews;
                    $roundedRating = round($productRating);
                @endphp
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="ph ph-star-fill text-lg {{ $i <= $roundedRating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ number_format($productRating, 1) }}</span>
                    <span class="text-gray-600">dari 5</span>
                    <a href="#reviews" class="text-blue-600 hover:text-blue-700 font-semibold">
                        ({{ $productReviews }} ulasan)
                    </a>
                </div>

                <!-- Price -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-baseline gap-3 mb-2">
                        <span class="text-4xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if($product->cost_price && $product->cost_price > $product->price)
                        <span class="text-xl text-gray-500 line-through">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                </div>

                <!-- Specifications -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Spesifikasi</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex gap-4">
                            <span class="text-gray-600 w-24">SKU:</span>
                            <span class="text-gray-900 font-semibold">{{ $product->sku ?? '-' }}</span>
                        </div>
                        <div class="flex gap-4">
                            <span class="text-gray-600 w-24">Berat:</span>
                            <span class="text-gray-900 font-semibold">{{ $product->weight ? $product->weight . ' gram' : '-' }}</span>
                        </div>
                        <div class="flex gap-4">
                            <span class="text-gray-600 w-24">Dimensi:</span>
                            <span class="text-gray-900 font-semibold">
                                {{ $product->length ?? '-' }} x {{ $product->width ?? '-' }} x {{ $product->height ?? '-' }} cm
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        @php
                            $stock = $product->stock;
                            $minStock = $product->min_stock ?? 10;
                        @endphp
                        @if($stock > $minStock)
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-green-700 font-semibold">Stok Tersedia ({{ $stock }} pcs)</span>
                        @elseif($stock > 0)
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-yellow-700 font-semibold">Stok Terbatas ({{ $stock }} pcs)</span>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-red-700 font-semibold">Stok Habis</span>
                        @endif
                    </div>
                </div>

                <!-- Options -->
                <div class="mb-6">
                    <!-- Quantity -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah
                        </label>
                        <div class="flex items-center gap-3 bg-gray-100 rounded-lg w-fit">
                            <button type="button" onclick="document.getElementById('qty').stepDown()" class="px-3 py-2 text-gray-600 hover:text-gray-900">
                                <i class="ph ph-minus"></i>
                            </button>
                            <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center bg-transparent outline-none font-semibold text-gray-900" form="add-to-cart-form">
                            <button type="button" onclick="document.getElementById('qty').stepUp()" class="px-3 py-2 text-gray-600 hover:text-gray-900">
                                <i class="ph ph-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                    <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <!-- quantity input is linked via form="add-to-cart-form" attribute -->
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                            <i class="ph ph-shopping-cart-fill text-xl"></i>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    
                    <form action="{{ route('wishlist.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 border-2 border-blue-600 text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition">
                            @php
                                $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                            @endphp
                            @if($inWishlist)
                                <i class="ph-fill ph-heart text-xl text-red-500"></i>
                                Hapus dari Wishlist
                            @else
                                <i class="ph ph-heart-fill text-xl"></i>
                                Tambah Wishlist
                            @endif
                        </button>
                    </form>
                </div>

                <!-- Seller Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                S
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">ShopHub Official Store</p>
                                <p class="text-xs text-gray-600">Toko Terpercaya</p>
                            </div>
                        </div>
                        <button class="px-4 py-2 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50">
                            Kunjungi Toko
                        </button>
                    </div>
                </div>

                <!-- Share -->
                <div class="flex items-center gap-2">
                    <span class="text-gray-600 text-sm">Bagikan:</span>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="ph ph-facebook-logo text-lg"></i>
                    </button>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="ph ph-twitter-logo text-lg"></i>
                    </button>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="ph ph-whatsapp-logo text-lg"></i>
                    </button>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="ph ph-link text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Details Tabs -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200 mt-8">
        <div class="mb-6 border-b border-gray-200">
            <div class="flex gap-8">
                <button class="px-0 py-4 text-gray-900 font-bold border-b-2 border-blue-600">
                    Informasi Produk
                </button>
                <button class="px-0 py-4 text-gray-600 font-semibold hover:text-gray-900">
                    Pengiriman & Pengembalian
                </button>
                <button class="px-0 py-4 text-gray-600 font-semibold hover:text-gray-900">
                    Ulasan (456)
                </button>
            </div>
        </div>

        <!-- Product Info Tab -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Lengkap</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Produk premium ini dirancang dengan mempertimbangkan kebutuhan pelanggan modern. 
                        Dengan material berkualitas tinggi dan proses manufaktur yang ketat, produk ini menjamin 
                        durabilitas dan performa optimal. Setiap detail dirancang dengan cermat untuk memberikan 
                        pengalaman terbaik kepada pengguna.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Fitur Utama</h3>
                    <ul class="space-y-2">
                        @foreach(['Desain Ergonomis', 'Material Premium', 'Tahan Lama', 'Garansi Resmi', 'Layanan Purna Jual'] as $feature)
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="ph ph-check-circle text-green-600 text-lg"></i>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200 h-fit">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="ph ph-info text-blue-600"></i>
                    Informasi Tambahan
                </h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-gray-600 mb-1">Waktu Pemrosesan</p>
                        <p class="font-semibold text-gray-900">1-2 hari kerja</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Pengiriman</p>
                        <p class="font-semibold text-gray-900">Ke Seluruh Indonesia</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Kebijakan Pengembalian</p>
                        <p class="font-semibold text-gray-900">30 Hari Uang Kembali</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200 mt-8" id="reviews">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Ulasan Pelanggan</h2>

        @if(session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-900">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-900">
                {{ session('error') }}
            </div>
        @endif

        <!-- Add Review Form (for authenticated users) -->
        @auth
            <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tulis Ulasan</h3>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $i }}" class="sr-only peer" {{ $i === 5 ? 'checked' : '' }}>
                                <label for="rating-{{ $i }}" class="cursor-pointer text-gray-300 hover:text-yellow-400 peer-checked:text-yellow-400">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Ulasan Anda</label>
                        <textarea name="comment" id="comment" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Bagikan pengalaman Anda dengan produk ini..." required></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
        @else
            <div class="bg-blue-50 rounded-lg p-6 mb-8 border border-blue-200">
                <div class="text-center">
                    <i class="ph ph-user-circle text-4xl text-blue-600 mb-2"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Masuk untuk Memberikan Ulasan</h3>
                    <p class="text-gray-600 mb-4">Anda perlu masuk ke akun Anda untuk memberikan ulasan pada produk ini.</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        Masuk
                    </a>
                </div>
            </div>
        @endauth

        <!-- Review Summary -->
        @php
            $activeReviewQuery = $product->comments()->approved();
            $totalComments = (clone $activeReviewQuery)->count();
            $averageRating = $totalComments > 0 ? (clone $activeReviewQuery)->avg('rating') : 0;
            $ratingCounts = [];
            for ($i = 1; $i <= 5; $i++) {
                $ratingCounts[$i] = (clone $activeReviewQuery)->where('rating', $i)->count();
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-6 text-center border border-gray-200">
                <p class="text-4xl font-bold text-gray-900 mb-1">{{ number_format($averageRating, 1) }}</p>
                <div class="flex justify-center mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="ph ph-star-fill {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <p class="text-sm text-gray-600">Berdasarkan {{ $totalComments }} ulasan</p>
            </div>

            @for($i = 5; $i >= 1; $i--)
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-sm text-gray-600">{{ $i }} <i class="ph ph-star-fill text-yellow-400 text-xs"></i></span>
                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-yellow-400" style="width: {{ $totalComments > 0 ? ($ratingCounts[$i] / $totalComments) * 100 : 0 }}%"></div>
                        </div>
                        <span class="text-sm text-gray-600">{{ $ratingCounts[$i] }}</span>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Reviews List -->
        <div class="space-y-6">
            @forelse($product->comments()->approved()->with('user')->latest()->get() as $comment)
                <div class="border-b border-gray-200 pb-6">
                    <!-- Reviewer Info -->
                    <div class="flex items-start gap-4 mb-3">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 font-medium">{{ substr($comment->user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-semibold text-gray-900">{{ $comment->user->name }}</p>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                @for($star = 1; $star <= 5; $star++)
                                    <i class="ph ph-star-fill {{ $star <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                @endfor
                                <span class="text-sm font-semibold text-gray-900">
                                    @if($comment->rating == 5) Sangat Memuaskan
                                    @elseif($comment->rating == 4) Memuaskan
                                    @elseif($comment->rating == 3) Cukup Baik
                                    @elseif($comment->rating == 2) Kurang Memuaskan
                                    @else Buruk
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review Content -->
                    <p class="text-gray-700 mb-3 whitespace-pre-wrap">{{ $comment->comment }}</p>

                    <!-- Helpful Button -->
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <button class="flex items-center gap-1 hover:text-blue-600">
                            <i class="ph ph-thumbs-up"></i>
                            Bermanfaat (0)
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="ph ph-chat-circle text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ulasan</h3>
                    <p class="text-gray-600">Jadilah yang pertama memberikan ulasan untuk produk ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Load More -->
        <div class="text-center mt-8">
            <button class="px-8 py-3 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50">
                Tampilkan Semua Ulasan
            </button>
        </div>
    </section>

    <!-- Related Products -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200 mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Produk Serupa</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach(range(1, 4) as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                    <!-- Image -->
                    <div class="relative bg-gray-200 h-48 overflow-hidden">
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="ph ph-image text-6xl"></i>
                        </div>
                        <button class="absolute top-2 right-2 bg-white rounded-full p-2 hover:bg-gray-100 shadow">
                            <i class="ph ph-heart text-xl text-gray-600"></i>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-2">
                            Produk Serupa {{ $product }}
                        </h3>
                        
                        <div class="flex items-center gap-1 mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <i class="ph ph-star-fill text-xs text-yellow-400"></i>
                            @endfor
                            <span class="text-xs text-gray-500">({{ rand(50, 300) }})</span>
                        </div>

                        <div class="mb-3">
                            <div class="text-lg font-bold text-gray-900">Rp {{ number_format(rand(50000, 400000), 0, ',', '.') }}</div>
                        </div>

                        <a href="/products/{{ $product }}" class="block text-center text-blue-600 font-semibold text-sm hover:text-blue-700">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-default-layout>
