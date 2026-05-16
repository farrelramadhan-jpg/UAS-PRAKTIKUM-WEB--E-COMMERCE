@extends('layouts.app')

@section('title', 'Pesanan - Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">Pesanan</h1>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left">No. Pesanan</th>
                        <th class="px-4 py-2 text-left">Pelanggan</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                            <td class="px-4 py-3">{{ ucfirst($order->status) }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
