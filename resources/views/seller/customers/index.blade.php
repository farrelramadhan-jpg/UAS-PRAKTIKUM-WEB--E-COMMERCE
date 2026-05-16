@extends('layouts.app')

@section('title', 'Pelanggan - Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">Pelanggan</h1>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Total Pesanan</th>
                        <th class="px-4 py-2 text-left">Total Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $customer->name }}</td>
                            <td class="px-4 py-3">{{ $customer->email }}</td>
                            <td class="px-4 py-3">{{ $customer->orders_count }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($customer->orders_sum_total_amount ?? 0,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center">Belum ada pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
