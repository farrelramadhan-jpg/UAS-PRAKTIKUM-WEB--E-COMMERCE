<x-auth-layout>
    <x-slot name="header">
        Edit Kategori
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama kategori"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Deskripsikan kategori ini (opsional)"
                        >{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('admin.categories.index') }}" class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-semibold text-center transition">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold transition">
                            Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-auth-layout>