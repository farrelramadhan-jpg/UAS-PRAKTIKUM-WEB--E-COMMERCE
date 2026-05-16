@extends('layouts.app')

@section('title', 'Pengaturan - Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">Pengaturan Toko</h1>

        <form action="{{ route('seller.settings.update') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Toko</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" class="mt-1 block w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="site_description" class="mt-1 block w-full border rounded p-2">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                </div>
                <div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
