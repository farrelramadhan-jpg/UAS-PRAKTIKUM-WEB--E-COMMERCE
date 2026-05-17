@extends('layouts.app')

@section('title', 'Detail Produk - Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <a href="{{ route('seller.products.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                <i class="ph ph-caret-left"></i>
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-sm text-gray-600 mb-4">SKU: {{ $product->sku }}</p>
                <p class="text-gray-700">{!! nl2br(e($product->description)) !!}</p>
            </div>
            <div class="space-y-4">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="w-full h-40 bg-gray-100 rounded mb-3 flex items-center justify-center">
                        <i class="ph ph-image text-4xl text-gray-300"></i>
                    </div>
                    <p class="text-lg font-bold text-blue-600">Rp {{ number_format($product->price,0,',','.') }}</p>
                    <p class="text-sm text-gray-600">Stok: {{ $product->stock }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <a href="{{ route('seller.products.edit', $product) }}" class="block bg-green-600 text-white px-4 py-2 rounded">Edit Produk</a>
                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="w-full bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Hapus produk ini?')">Hapus Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
