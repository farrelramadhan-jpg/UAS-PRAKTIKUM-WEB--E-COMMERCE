@extends('layouts.app')

@section('title', 'Kelola Ulasan Produk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Ulasan Produk</h1>
            <a href="{{ route('moderator.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800">Menunggu</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
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
                        <h3 class="text-lg font-medium text-green-800">Disetujui</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
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
                        <h3 class="text-lg font-medium text-red-800">Ditolak</h3>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
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
                        <h3 class="text-lg font-medium text-blue-800">Total</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('moderator.comments.index', ['status' => 'pending']) }}"
                   class="px-4 py-2 text-sm font-medium rounded-md {{ $status === 'pending' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Menunggu ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('moderator.comments.index', ['status' => 'approved']) }}"
                   class="px-4 py-2 text-sm font-medium rounded-md {{ $status === 'approved' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Disetujui ({{ $stats['approved'] }})
                </a>
                <a href="{{ route('moderator.comments.index', ['status' => 'rejected']) }}"
                   class="px-4 py-2 text-sm font-medium rounded-md {{ $status === 'rejected' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Ditolak ({{ $stats['rejected'] }})
                </a>
                <a href="{{ route('moderator.comments.index', ['status' => 'all']) }}"
                   class="px-4 py-2 text-sm font-medium rounded-md {{ $status === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Semua ({{ $stats['total'] }})
                </a>
            </nav>
        </div>

        <!-- Bulk Actions Form -->
        <form id="bulk-action-form" action="{{ route('moderator.comments.bulk-action') }}" method="POST" class="mb-4">
            @csrf
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label for="select-all" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                </div>
                <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Pilih Aksi</option>
                    <option value="approve">Setujui</option>
                    <option value="reject">Tolak</option>
                    <option value="delete">Hapus</option>
                </select>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Terapkan
                </button>
            </div>
        </form>

        <!-- Comments List -->
        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 {{ $comment->status === 'pending' ? 'border-l-4 border-l-yellow-400' : ($comment->status === 'approved' ? 'border-l-4 border-l-green-400' : 'border-l-4 border-l-red-400') }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" form="bulk-action-form" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 comment-checkbox">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $comment->user->name }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $comment->getStatusColor() }}">
                                    {{ $comment->getStatusText() }}
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
                                Produk: <a href="{{ route('products.public.show', $comment->product) }}" class="text-indigo-600 hover:text-indigo-800">{{ $comment->product->name }}</a>
                            </p>

                            <p class="text-gray-800 mb-3">{{ $comment->comment }}</p>

                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <span>Dibuat: {{ $comment->created_at->format('d M Y, H:i') }}</span>
                                @if($comment->approved_at)
                                    <span>Dimoderasi: {{ $comment->approved_at->format('d M Y, H:i') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2 ml-4">
                            @if($comment->status === 'pending')
                                <form action="{{ route('moderator.comments.approve', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        Setujui
                                    </button>
                                </form>

                                <button onclick="rejectComment('{{ $comment->id }}')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Tolak
                                </button>
                            @endif

                            <a href="{{ route('moderator.comments.show', $comment) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm text-center">
                                Lihat
                            </a>

                            <form action="{{ route('moderator.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada ulasan</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada ulasan yang perlu dimoderasi.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($comments->hasPages())
            <div class="mt-6">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Ulasan</h3>
            <form id="reject-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan (Opsional)</label>
                    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Berikan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentRejectCommentId = null;

function rejectComment(commentId) {
    currentRejectCommentId = commentId;
    document.getElementById('reject-form').action = `/moderator/comments/${commentId}/reject`;
    document.getElementById('reject-modal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    document.getElementById('reason').value = '';
    currentRejectCommentId = null;
}

// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.comment-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Close modal when clicking outside
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session("success") }}');
        });
    </script>
@endif
@endsection