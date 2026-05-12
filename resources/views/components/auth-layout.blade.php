<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'E-Commerce') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Phospor Icons -->
        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-900 text-white sticky top-0 h-screen overflow-y-auto">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-700">
                    <div class="flex items-center gap-2">
                        <i class="ph ph-shopping-cart text-2xl text-blue-400"></i>
                        <div>
                            <h1 class="text-xl font-bold">ShopHub</h1>
                            <p class="text-xs text-gray-400">Admin Panel</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="p-6 space-y-2">
                    <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->is('admin/dashboard') ? 'bg-blue-600' : '' }}">
                        <i class="ph ph-house text-xl"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->is('admin/categories*') ? 'bg-blue-600' : '' }}">
                        <i class="ph ph-list text-xl"></i>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->is('admin/orders*') ? 'bg-blue-600' : '' }}">
                        <i class="ph ph-receipt text-xl"></i>
                        <span>Pesanan</span>
                    </a>

                    <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->is('admin/customers*') ? 'bg-blue-600' : '' }}">
                        <i class="ph ph-users text-xl"></i>
                        <span>Pelanggan</span>
                    </a>

                    <div class="border-t border-gray-700 my-4"></div>

                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->is('admin/settings*') ? 'bg-blue-600' : '' }}">
                        <i class="ph ph-gear text-xl"></i>
                        <span>Pengaturan</span>
                    </a>
                </nav>

                <!-- User Info -->
                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gray-800 border-t border-gray-700">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">Admin</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="/profile" class="flex-1 text-center px-2 py-2 text-xs hover:bg-gray-700 rounded transition">
                            <i class="ph ph-user"></i>
                        </a>
                        <form method="POST" action="/logout" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full text-center px-2 py-2 text-xs hover:bg-gray-700 rounded transition">
                                <i class="ph ph-sign-out"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Top Bar -->
                <header class="bg-white shadow">
                    <div class="px-6 py-4 flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? 'Dashboard' }}</h1>
                        <button class="md:hidden text-gray-600">
                            <i class="ph ph-list text-2xl"></i>
                        </button>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-auto">
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
