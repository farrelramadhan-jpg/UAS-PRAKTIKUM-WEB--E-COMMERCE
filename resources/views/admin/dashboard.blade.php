@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                Admin Panel
            </span>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Manajemen Utama</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <a href="{{ route('admin.users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-users text-2xl mb-1"></i><br>
                    Manajemen Pengguna
                </a>
                <a href="{{ route('admin.products.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-package text-2xl mb-1"></i><br>
                    Produk
                </a>
                <a href="{{ route('admin.categories.index') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-folder text-2xl mb-1"></i><br>
                    Kategori
                </a>
                <a href="{{ route('admin.orders.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-shopping-cart text-2xl mb-1"></i><br>
                    Pesanan
                </a>
                <a href="{{ route('admin.settings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-gear text-2xl mb-1"></i><br>
                    Pengaturan
                </a>
            </div>
        </div>

        <!-- Secondary Actions -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Kelola Konten</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.customers.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-user-circle text-2xl mb-1"></i><br>
                    Pelanggan
                </a>
                <a href="{{ route('moderator.comments.index') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-chat-circle text-2xl mb-1"></i><br>
                    Ulasan Produk
                </a>
                <a href="/" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-eye text-2xl mb-1"></i><br>
                    Lihat Website
                </a>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Total Pengguna</p>
                        <p class="text-3xl font-bold text-blue-900 mt-2">{{ \App\Models\User::count() }}</p>
                    </div>
                    <svg class="h-12 w-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10h.01M11 10h.01M7 10h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Total Produk</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">{{ \App\Models\Product::count() }}</p>
                    </div>
                    <svg class="h-12 w-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0-10v10l-8 4"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-medium">Total Pesanan</p>
                        <p class="text-3xl font-bold text-purple-900 mt-2">{{ \App\Models\Order::count() }}</p>
                    </div>
                    <svg class="h-12 w-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-medium">Total Ulasan</p>
                        <p class="text-3xl font-bold text-yellow-900 mt-2">{{ \App\Models\Comment::count() }}</p>
                    </div>
                    <svg class="h-12 w-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
