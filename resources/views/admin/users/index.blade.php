<x-auth-layout>
    <x-slot name="header">
        Manajemen Pengguna
    </x-slot>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-900 flex items-center gap-3">
                    <i class="ph ph-users-three text-blue-600"></i>
                    Manajemen Pengguna
                </h1>
                <p class="text-gray-500 text-sm mt-1">Kelola hak akses dan peran seluruh pengguna terdaftar pada platform.</p>
            </div>
        </div>

        <!-- Main Card Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <!-- Filter Tabs & Actions -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-6 border-b border-gray-50">
                <nav class="flex flex-wrap gap-2 p-1 bg-gray-50 rounded-xl border border-gray-100">
                    <a href="{{ route('admin.users.index', ['role' => 'all']) }}"
                       class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all
                       {{ $role === 'all' ? 'bg-white text-blue-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }}">
                        Semua ({{ $stats['total'] }})
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
                       class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all
                       {{ $role === 'admin' ? 'bg-white text-purple-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }}">
                        Admin ({{ $stats['admin'] }})
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'moderator']) }}"
                       class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all
                       {{ $role === 'moderator' ? 'bg-white text-green-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }}">
                        Moderator ({{ $stats['moderator'] }})
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'seller']) }}"
                       class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all
                       {{ $role === 'seller' ? 'bg-white text-amber-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }}">
                        Seller ({{ $stats['seller'] }})
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'buyer']) }}"
                       class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all
                       {{ $role === 'buyer' ? 'bg-white text-indigo-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }}">
                        Pembeli ({{ $stats['buyer'] }})
                    </a>
                </nav>
            </div>

            <!-- Notifications -->
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-100 bg-green-50/50 p-4 text-green-700 flex items-center gap-3">
                    <i class="ph ph-check-circle text-xl"></i>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-xl border border-red-100 bg-red-50/50 p-4 text-red-700 flex items-center gap-3">
                    <i class="ph ph-warning-circle text-xl"></i>
                    <span class="text-sm font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 rounded-xl overflow-hidden">
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest rounded-l-xl">Nama Pengguna</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Email</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Hak Akses (Role)</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Total Belanja (Pesanan)</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tanggal Gabung</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest rounded-r-xl text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm shadow-sm border
                                            {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-100' : '' }}
                                            {{ $user->role === 'moderator' ? 'bg-green-50 text-green-600 border-green-100' : '' }}
                                            {{ $user->role === 'seller' ? 'bg-amber-50 text-amber-600 border-amber-100' : '' }}
                                            {{ $user->role === 'buyer' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : '' }}">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800 block">{{ $user->name }}</span>
                                            <span class="text-gray-400 text-xs font-medium">ID: #{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-gray-600 font-medium">{{ $user->email }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl border font-bold text-xs shadow-sm focus:outline-none transition cursor-pointer
                                            {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-200 focus:ring-purple-200' : '' }}
                                            {{ $user->role === 'moderator' ? 'bg-green-50 text-green-700 border-green-200 focus:ring-green-200' : '' }}
                                            {{ $user->role === 'seller' ? 'bg-amber-50 text-amber-700 border-amber-200 focus:ring-amber-200' : '' }}
                                            {{ $user->role === 'buyer' ? 'bg-indigo-50 text-indigo-700 border-indigo-200 focus:ring-indigo-200' : '' }}">
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                            <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                            <option value="buyer" {{ $user->role === 'buyer' ? 'selected' : '' }}>Pembeli</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 bg-gray-50 border border-gray-100 rounded-lg text-xs font-black text-gray-500 uppercase">
                                        {{ $user->orders_count ?? 0 }} Pesanan
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm text-gray-500 font-medium">{{ $user->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-600 hover:text-white rounded-xl text-red-600 transition flex items-center justify-center mx-auto shadow-sm border border-red-100">
                                                <i class="ph ph-trash text-base"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs font-bold italic uppercase tracking-wider">Sesi Anda</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">
                                    <i class="ph ph-info text-2xl mb-2 block"></i>
                                    Tidak ada pengguna terdaftar dengan kriteria ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-8 pt-6 border-t border-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-auth-layout>

