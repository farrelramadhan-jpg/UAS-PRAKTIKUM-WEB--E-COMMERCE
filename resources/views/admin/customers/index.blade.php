<x-auth-layout>
    <x-slot name="header">
        Kelola Pelanggan
    </x-slot>

    <div class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="ph ph-users text-3xl text-purple-600"></i>
                    Daftar Pelanggan
                </h1>
                <p class="text-gray-600 text-sm mt-1">Kelola data pelanggan yang terdaftar</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 font-semibold">
                <i class="ph ph-plus-circle"></i>
                Tambah Pelanggan
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Pelanggan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $customers->total() }}</p>
                    </div>
                    <i class="ph ph-users text-4xl text-purple-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Aktif Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeThisMonth }}</p>
                    </div>
                    <i class="ph ph-user-check text-4xl text-blue-600 opacity-20"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Dengan Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $customersWithOrders }}</p>
                    </div>
                    <i class="ph ph-shopping-cart text-4xl text-green-600 opacity-20"></i>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Belanja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <span class="text-purple-600 font-bold text-sm">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $customer->email }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                {{ $customer->orders_count ?? 0 }} pesanan
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                Rp {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $customer->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-blue-600 hover:text-blue-700 p-2 hover:bg-blue-50 rounded transition" title="Detail">
                                        <i class="ph ph-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="text-orange-600 hover:text-orange-700 p-2 hover:bg-orange-50 rounded transition" title="Edit">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded transition" title="Hapus" onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="ph ph-users text-4xl mb-4 block"></i>
                                <p>Belum ada pelanggan</p>
                                <a href="{{ route('admin.customers.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Buat pelanggan pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</x-auth-layout>