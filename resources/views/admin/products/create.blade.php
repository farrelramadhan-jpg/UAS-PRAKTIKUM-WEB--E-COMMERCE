<x-auth-layout>
    <x-slot name="header">
        Tambah Produk Baru
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold">
            <i class="ph ph-caret-left"></i>
            Kembali ke Daftar Produk
        </a>
    </div>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-info text-blue-600"></i>
                        Informasi Dasar
                    </h3>

                    <!-- Product Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name"
                            placeholder="Masukkan nama produk" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                        @error('name')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <i class="ph ph-warning-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            SKU <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="sku"
                            placeholder="Misal: SKU-001" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                        @error('sku')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <i class="ph ph-warning-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Produk <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="description"
                            placeholder="Tuliskan deskripsi detail produk..." 
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        ></textarea>
                        @error('description')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <i class="ph ph-warning-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">Deskripsi dapat berisi spesifikasi, fitur, dan keunggulan produk</p>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-currency-dollar text-blue-600"></i>
                        Harga & Stok
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-600">Rp</span>
                                <input 
                                    type="number" 
                                    name="price"
                                    placeholder="0" 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                            </div>
                            @error('price')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class="ph ph-warning-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Cost Price -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga Beli (Opsional)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-600">Rp</span>
                                <input 
                                    type="number" 
                                    name="cost_price"
                                    placeholder="0" 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="stock"
                                placeholder="0" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                            @error('stock')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class="ph ph-warning-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Min Stock -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok Minimum (Opsional)
                            </label>
                            <input 
                                type="number" 
                                name="min_stock"
                                placeholder="10" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-image text-blue-600"></i>
                        Gambar Produk
                    </h3>

                    <!-- Main Image -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Gambar Utama <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition cursor-pointer">
                            <i class="ph ph-cloud-upload-light text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-700 font-semibold">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-500">atau drag & drop (PNG, JPG max 2MB)</p>
                            <input type="file" name="main_image" accept="image/*" class="hidden">
                        </div>
                        @error('main_image')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <i class="ph ph-warning-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Galeri Gambar (Opsional)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition cursor-pointer">
                            <i class="ph ph-images text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-700 font-semibold">Klik untuk upload lebih banyak gambar</p>
                            <p class="text-xs text-gray-500">Maksimal 5 gambar</p>
                            <input type="file" name="gallery_images[]" accept="image/*" multiple class="hidden">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category & Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-list text-blue-600"></i>
                        Kategori & Status
                    </h3>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <i class="ph ph-warning-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="is_active" value="1" checked class="w-4 h-4">
                                <span class="text-gray-700 text-sm">
                                    <i class="ph ph-check-circle text-green-600"></i> Aktif
                                </span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="is_active" value="0" class="w-4 h-4">
                                <span class="text-gray-700 text-sm">
                                    <i class="ph ph-x-circle text-gray-600"></i> Tidak Aktif
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-package text-blue-600"></i>
                        Informasi Tambahan
                    </h3>

                    <!-- Weight -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Berat (g)
                        </label>
                        <input 
                            type="number" 
                            name="weight"
                            placeholder="0" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- Dimensions -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Dimensi (cm)
                        </label>
                        <div class="grid grid-cols-3 gap-2">
                            <input 
                                type="number" 
                                name="length"
                                placeholder="Panjang" 
                                class="w-full px-2 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <input 
                                type="number" 
                                name="width"
                                placeholder="Lebar" 
                                class="w-full px-2 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <input 
                                type="number" 
                                name="height"
                                placeholder="Tinggi" 
                                class="w-full px-2 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-eye text-blue-600"></i>
                        Pratinjau
                    </h3>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="w-full h-40 bg-gray-100 rounded mb-3 flex items-center justify-center">
                            <i class="ph ph-image text-4xl text-gray-300"></i>
                        </div>
                        <p class="font-semibold text-gray-700 text-sm line-clamp-2">Nama Produk</p>
                        <p class="text-lg font-bold text-blue-600 mt-2">Rp 0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 sticky bottom-0 bg-white rounded-lg shadow p-6 -mx-6 -mb-6">
            <button type="reset" class="flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold">
                <i class="ph ph-arrow-counter-clockwise"></i>
                Reset
            </button>
            <button type="submit" class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                <i class="ph ph-check-circle"></i>
                Simpan Produk
            </button>
            <a href="{{ route('products.index') }}" class="flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold">
                <i class="ph ph-x"></i>
                Batal
            </a>
        </div>
    </form>
</x-auth-layout>
