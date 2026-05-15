@extends('layouts.app')

@section('title', 'Detail Ulasan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Detail Ulasan</h1>
                <a href="{{ route('moderator.comments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Comment Details -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Ulasan</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-500">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $comment->getStatusColor() }}">
                                    {{ $comment->getStatusText() }}
                                </span>
                            </div>

                            @if($comment->rating)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-500">Rating:</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600">({{ $comment->rating }}/5)</span>
                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-500">Dibuat:</span>
                                <span class="text-sm text-gray-900">{{ $comment->created_at->format('d M Y, H:i:s') }}</span>
                            </div>

                            @if($comment->approved_at)
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Dimoderasi:</span>
                                    <span class="text-sm text-gray-900">{{ $comment->approved_at->format('d M Y, H:i:s') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Comment Content -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Isi Ulasan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $comment->comment }}</p>
                        </div>
                    </div>
                </div>

                <!-- User and Product Info -->
                <div class="space-y-4">
                    <!-- User Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Pengguna</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">{{ substr($comment->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $comment->user->email }}</p>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Role:</span>
                                    <span class="text-sm text-gray-900">{{ ucfirst($comment->user->role) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Bergabung:</span>
                                    <span class="text-sm text-gray-900">{{ $comment->user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Produk</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center space-x-3">
                                @if($comment->product->image)
                                    <img src="{{ asset('storage/' . $comment->product->image) }}" alt="{{ $comment->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-300 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('products.public.show', $comment->product) }}" class="text-indigo-600 hover:text-indigo-800">
                                            {{ $comment->product->name }}
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-500">{{ $comment->product->category->name }}</p>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Harga:</span>
                                    <span class="text-sm text-gray-900">Rp {{ number_format($comment->product->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Stok:</span>
                                    <span class="text-sm text-gray-900">{{ $comment->product->stock }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-center space-x-4">
                @if($comment->status === 'pending')
                    <form action="{{ route('moderator.comments.approve', $comment) }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                            Setujui Ulasan
                        </button>
                    </form>

                    <button onclick="rejectComment()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium">
                        Tolak Ulasan
                    </button>
                @endif

                <form action="{{ route('moderator.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium">
                        Hapus Ulasan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Ulasan</h3>
            <form action="{{ route('moderator.comments.reject', $comment) }}" method="POST">
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
function rejectComment() {
    document.getElementById('reject-modal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    document.getElementById('reason').value = '';
}

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
            alert('{{ session('success') }}');
        });
    </script>
@endif
@endsection