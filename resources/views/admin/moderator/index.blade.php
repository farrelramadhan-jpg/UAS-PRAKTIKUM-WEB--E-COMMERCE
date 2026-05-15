@extends('layouts.app')

@section('title', 'Dashboard Moderator')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Moderator</h1>
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                Moderator Panel
            </span>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800">Ulasan Menunggu</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Comment::where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-green-800">Ulasan Disetujui</h3>
                        <p class="text-2xl font-bold text-green-600">{{ \App\Models\Comment::where('status', 'approved')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-red-800">Ulasan Ditolak</h3>
                        <p class="text-2xl font-bold text-red-600">{{ \App\Models\Comment::where('status', 'rejected')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-800">Total Ulasan</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Comment::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('moderator.comments.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-chat-circle text-xl mb-1"></i>
                    Kelola Ulasan
                </a>
                <a href="{{ route('moderator.comments.index', ['status' => 'pending']) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-clock text-xl mb-1"></i>
                    Moderasi Menunggu
                </a>
                <a href="{{ route('products.public.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium text-center transition">
                    <i class="ph ph-storefront text-xl mb-1"></i>
                    Lihat Produk
                </a>
            </div>
        </div>

        <!-- Recent Pending Comments -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-900">Ulasan Terbaru Menunggu Moderasi</h2>
                <a href="{{ route('moderator.comments.index', ['status' => 'pending']) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-4">
                @forelse(\App\Models\Comment::with(['user', 'product'])->where('status', 'pending')->latest()->limit(5)->get() as $comment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                                        Menunggu Moderasi
                                    </span>
                                    @if($comment->rating)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    @endif
                                </div>

                                <p class="text-sm text-gray-600 mb-2">
                                    Produk: <span class="font-medium">{{ $comment->product->name }}</span>
                                </p>

                                <p class="text-gray-800 text-sm line-clamp-2">{{ Str::limit($comment->comment, 150) }}</p>

                                <p class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('moderator.comments.show', $comment) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm text-center">
                                    Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03 8 9 8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada ulasan menunggu moderasi</h3>
                        <p class="mt-1 text-sm text-gray-500">Semua ulasan telah dimoderasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
