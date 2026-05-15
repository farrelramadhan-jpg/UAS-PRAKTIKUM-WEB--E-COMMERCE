<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'E-Commerce') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Phospor Icons -->
        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col">
            <!-- Navbar -->
            <nav class="bg-white shadow-md sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex items-center gap-2">
                            <i class="ph ph-shopping-cart text-2xl text-blue-600"></i>
                            <a href="/" class="text-xl font-bold text-gray-900">ShopHub</a>
                        </div>

                        <!-- Search Bar -->
                        <div class="hidden md:flex flex-1 mx-8">
                            <form action="{{ route('products.public.index') }}" method="GET" class="w-full relative">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <input 
                                    type="text" 
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari produk..." 
                                    class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-blue-600 transition">
                                    <i class="ph ph-magnifying-glass text-xl"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Right Menu -->
                        <div class="flex items-center gap-4">
                            <a href="/wishlist" class="relative text-gray-600 hover:text-red-500 transition">
                                <i class="ph ph-heart text-2xl"></i>
                                @auth
                                    @php $wishlistCount = Auth::user()->wishlists()->count(); @endphp
                                    @if($wishlistCount > 0)
                                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $wishlistCount }}</span>
                                    @endif
                                @endauth
                            </a>
                            <a href="/cart" class="relative text-gray-600 hover:text-blue-600 transition">
                                <i class="ph ph-shopping-cart text-2xl"></i>
                                @auth
                                    @php $cartCount = Auth::user()->carts()->sum('quantity'); @endphp
                                    @if($cartCount > 0)
                                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                                    @endif
                                @endauth
                            </a>
                            @auth
                                <div class="relative group">
                                    <button class="flex items-center gap-2 text-gray-600 hover:text-gray-900">
                                        <i class="ph ph-user text-2xl"></i>
                                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200">
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.dashboard.main') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="ph ph-house"></i> Admin Panel
                                            </a>
                                        @elseif(Auth::user()->role === 'seller')
                                            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="ph ph-storefront"></i> Seller Panel
                                            </a>
                                        @elseif(Auth::user()->role === 'moderator')
                                            <a href="{{ route('moderator.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="ph ph-shield-check"></i> Moderator Panel
                                            </a>
                                        @endif
                                        <a href="/profile" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 border-t">
                                            <i class="ph ph-user"></i> Profil
                                        </a>
                                        <form method="POST" action="/logout" class="border-t">
                                            @csrf
                                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="ph ph-sign-out"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="/login" class="text-blue-600 hover:text-blue-700 font-medium">Login</a>
                                <a href="/register" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Daftar</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 text-gray-300 mt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- About -->
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <i class="ph ph-shopping-cart text-2xl text-blue-400"></i>
                                <h3 class="text-lg font-bold text-white">ShopHub</h3>
                            </div>
                            <p class="text-sm">Belanja online terpercaya dengan produk berkualitas dan harga terjangkau.</p>
                        </div>

                        <!-- Links -->
                        <div>
                            <h4 class="text-white font-semibold mb-4">Belanja</h4>
                            <ul class="space-y-2 text-sm">
                                <li><a href="#" class="hover:text-white">Kategori</a></li>
                                <li><a href="#" class="hover:text-white">Produk Terbaru</a></li>
                                <li><a href="#" class="hover:text-white">Flash Sale</a></li>
                            </ul>
                        </div>

                        <!-- Customer Service -->
                        <div>
                            <h4 class="text-white font-semibold mb-4">Dukungan</h4>
                            <ul class="space-y-2 text-sm">
                                <li><a href="#" class="hover:text-white">Hubungi Kami</a></li>
                                <li><a href="#" class="hover:text-white">FAQ</a></li>
                                <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                            </ul>
                        </div>

                        <!-- Follow -->
                        <div>
                            <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
                            <div class="flex gap-4">
                                <a href="#" class="text-gray-400 hover:text-white text-2xl">
                                    <i class="ph ph-facebook-logo"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-white text-2xl">
                                    <i class="ph ph-instagram-logo"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-white text-2xl">
                                    <i class="ph ph-twitter-logo"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                        <p>&copy; 2026 ShopHub. Semua hak dilindungi.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
