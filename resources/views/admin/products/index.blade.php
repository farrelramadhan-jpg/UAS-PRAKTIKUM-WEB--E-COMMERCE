<x-auth-layout>
    <x-slot name="header">
        Kelola Produk
    </x-slot>

    <div class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="ph ph-package text-3xl text-blue-600"></i>
                    Daftar Produk
                </h1>
                <p class="text-gray-600 text-sm mt-1">Kelola dan pantau semua produk di toko Anda</p>
            </div>
            <a href="/admin/products/create" class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                <i class="ph ph-plus-circle"></i>
                Tambah Produk
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-900">1,234</p>
                    </div>
                    <i class="ph ph-package text-4xl text-blue-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Stok Rendah</p>
                        <p class="text-2xl font-bold text-gray-900">12</p>
                    </div>
                    <i class="ph ph-warning-circle text-4xl text-green-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Terjual Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">45</p>
                    </div>
                    <i class="ph ph-chart-line text-4xl text-orange-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Tidak Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">8</p>
                    </div>
                    <i class="ph ph-x-circle text-4xl text-red-600 opacity-20"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Nama produk..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <i class="ph ph-magnifying-glass absolute right-3 top-2.5 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Semua Kategori</option>
                        <option>Fashion</option>
                        <option>Elektronik</option>
                        <option>Buku</option>
                        <option>Rumah & Taman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold flex items-center justify-center gap-2">
                        <i class="ph ph-funnel"></i>
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            <input type="checkbox" class="rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(range(1, 10) as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm">
                                <input type="checkbox" class="rounded">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="ph ph-image text-gray-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Produk {{ $product }}</p>
                                        <p class="text-xs text-gray-500">SKU-00{{ $product }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($product % 3 === 0)
                                    Fashion
                                @elseif($product % 3 === 1)
                                    Elektronik
                                @else
                                    Buku
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                Rp {{ number_format(rand(50000, 500000), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $stok = rand(0, 150);
                                    $stokClass = $stok < 10 ? 'text-red-600' : ($stok < 50 ? 'text-yellow-600' : 'text-green-600');
                                @endphp
                                <span class="{{ $stokClass }} font-semibold">{{ $stok }} pcs</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ rand(10, 500) }} pcs
                            </td>
                            <td class="px-6 py-4">
                                @if($product % 2 === 0)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <i class="ph ph-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        <i class="ph ph-x-circle"></i> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="/admin/products/{{ $product }}" class="text-blue-600 hover:text-blue-700 p-2 hover:bg-blue-50 rounded transition" title="Detail">
                                        <i class="ph ph-eye"></i>
                                    </a>
                                    <a href="/admin/products/{{ $product }}/edit" class="text-orange-600 hover:text-orange-700 p-2 hover:bg-orange-50 rounded transition" title="Edit">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <button class="text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded transition" title="Hapus">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold">1-10</span> dari <span class="font-semibold">1,234</span> produk
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-gray-300 rounded text-gray-600 hover:bg-gray-100 disabled:opacity-50" disabled>
                    <i class="ph ph-caret-left"></i>
                </button>
                @for($i = 1; $i <= 3; $i++)
                    <button class="px-3 py-1 rounded {{ $i === 1 ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                        {{ $i }}
                    </button>
                @endfor
                <span class="px-3 py-1">...</span>
                <button class="px-3 py-1 border border-gray-300 rounded text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-caret-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="mt-6 flex gap-2">
        <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
            <i class="ph ph-download"></i>
            Export
        </button>
        <button class="flex items-center gap-2 px-4 py-2 border border-red-300 rounded-lg text-red-700 hover:bg-red-50 font-medium">
            <i class="ph ph-trash"></i>
            Hapus Dipilih
        </button>
    </div>
</x-auth-layout>
