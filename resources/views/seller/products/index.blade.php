@extends('layouts.app')

@section('title', 'Kelola Produk - Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Kelola Produk</h1>
            <a href="{{ route('seller.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Produk</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Kategori</th>
                        <th class="px-4 py-2 text-left">Harga</th>
                        <th class="px-4 py-2 text-left">Stok</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category?->name }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($product->price,0,',','.') }}</td>
                            <td class="px-4 py-3">{{ $product->stock }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('seller.products.show', $product) }}" class="text-blue-600">Lihat</a>
                                |
                                <a href="{{ route('seller.products.edit', $product) }}" class="text-green-600">Edit</a>
                                |
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
