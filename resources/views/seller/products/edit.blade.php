@extends('layouts.app')

@section('title', 'Edit Produk - Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <a href="{{ route('seller.products.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                <i class="ph ph-caret-left"></i>
                Kembali ke Daftar Produk
            </a>
        </div>

        <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold mb-4">Informasi Dasar</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-2">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Deskripsi</label>
                            <textarea name="description" rows="6" class="w-full px-4 py-2 border rounded" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold mb-4">Harga & Stok</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-2">Harga</label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border rounded" required>
                            </div>
                            <div>
                                <label class="block text-sm mb-2">Stok</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-2 border rounded" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold mb-4">Kategori & Status</h3>
                        <div class="mb-4">
                            <label class="block text-sm mb-2">Kategori</label>
                            <select name="category_id" class="w-full px-4 py-2 border rounded">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="mr-2">
                                Aktif
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Simpan Perubahan</button>
                        <a href="{{ route('seller.products.index') }}" class="ml-2 text-gray-700">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
