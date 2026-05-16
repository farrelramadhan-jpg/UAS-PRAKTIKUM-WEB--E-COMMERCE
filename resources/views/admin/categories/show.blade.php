<x-auth-layout>
    <x-slot name="header">
        Detail Kategori
    </x-slot>

    <div class="max-w-4xl">
        <!-- Category Info -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-list text-green-600 text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                            <p class="text-gray-600">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 font-semibold transition">
                            <i class="ph ph-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-semibold transition" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                <i class="ph ph-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $category->products->count() }}</div>
                        <div class="text-sm text-gray-600">Total Produk</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $category->products->where('is_active', true)->count() }}</div>
                        <div class="text-sm text-gray-600">Produk Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">Rp {{ number_format($category->products->sum('price'), 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-600">Total Nilai Produk</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products in Category -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Produk dalam Kategori Ini</h2>
                <p class="text-gray-600 text-sm mt-1">Daftar semua produk yang termasuk dalam kategori {{ $category->name }}</p>
            </div>

            <div class="p-6">
                @if($category->products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($category->products as $product)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start gap-3">
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($product->main_image)
                                            <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="ph ph-image text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-600 truncate">{{ $product->sku }}</p>
                                        <p class="text-lg font-bold text-green-600 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            @if($product->is_active)
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                    <i class="ph ph-check-circle"></i> Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                    <i class="ph ph-x-circle"></i> Tidak Aktif
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500">{{ $product->stock }} stok</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="flex-1 text-center text-blue-600 hover:text-blue-700 text-sm font-semibold py-2 px-3 border border-blue-600 rounded hover:bg-blue-50 transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 text-center text-orange-600 hover:text-orange-700 text-sm font-semibold py-2 px-3 border border-orange-600 rounded hover:bg-orange-50 transition">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="ph ph-package text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada produk</h3>
                        <p class="text-gray-600 mb-4">Kategori ini belum memiliki produk apapun</p>
                        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                            Tambah Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 font-semibold transition">
                ← Kembali ke Daftar Kategori
            </a>
        </div>
    </div>
</x-auth-layout>