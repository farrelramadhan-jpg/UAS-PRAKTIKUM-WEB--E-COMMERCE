<x-auth-layout>
    <x-slot name="header">
        Kelola Kategori
    </x-slot>

    <div class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="ph ph-list text-3xl text-green-600"></i>
                    Daftar Kategori
                </h1>
                <p class="text-gray-600 text-sm mt-1">Kelola kategori produk di toko Anda</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                <i class="ph ph-plus-circle"></i>
                Tambah Kategori
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                    </div>
                    <i class="ph ph-list text-4xl text-green-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Kategori Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $categories->where('is_active', true)->count() }}</p>
                    </div>
                    <i class="ph ph-check-circle text-4xl text-blue-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Produk per Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $categories->avg(fn($cat) => $cat->products_count ?? 0) }}</p>
                    </div>
                    <i class="ph ph-package text-4xl text-orange-600 opacity-20"></i>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jumlah Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="ph ph-list text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $category->slug ?? 'No slug' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ Str::limit($category->description ?? 'Tidak ada deskripsi', 50) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                {{ $category->products_count ?? $category->products->count() }} produk
                            </td>
                            <td class="px-6 py-4">
                                @if($category->is_active ?? true)
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
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-700 p-2 hover:bg-blue-50 rounded transition" title="Detail">
                                        <i class="ph ph-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-orange-600 hover:text-orange-700 p-2 hover:bg-orange-50 rounded transition" title="Edit">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded transition" title="Hapus" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="ph ph-list text-4xl mb-4 block"></i>
                                <p>Belum ada kategori yang dibuat</p>
                                <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Buat kategori pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-auth-layout>