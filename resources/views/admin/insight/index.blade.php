<x-default-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">💡 AI Insight: Analisis Dead Stock</h2>
        
        <div class="bg-white shadow rounded-lg mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Data Produk Pengawasan AI</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sisa Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-500 uppercase">Total Terjual</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-bold">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-sm text-red-600 font-bold">{{ $product->total_sold }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 shadow rounded-lg p-6 prose prose-blue max-w-none">
            {!! $insightHtml !!}
        </div>
        
        <div class="mt-4 text-xs text-gray-500 text-right">
            *Dianalisis secara otomatis oleh Groq Llama-3 AI.
        </div>
    </div>
</x-default-layout>