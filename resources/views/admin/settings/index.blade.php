<x-auth-layout>
    <x-slot name="header">
        Pengaturan Sistem
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="ph ph-gear text-2xl text-gray-600"></i>
                    Konfigurasi Sistem
                </h1>
                <p class="text-gray-600 text-sm mt-1">Kelola pengaturan umum aplikasi e-commerce</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-8">
                @csrf

                <!-- Site Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-globe text-lg text-blue-600"></i>
                        Informasi Situs
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Situs</label>
                            <input
                                type="text"
                                id="site_name"
                                name="site_name"
                                value="{{ old('site_name', $settings['site_name']) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                        </div>
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                            <input
                                type="email"
                                id="contact_email"
                                name="contact_email"
                                value="{{ old('contact_email', $settings['contact_email']) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                        </div>
                        <div class="md:col-span-2">
                            <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Situs</label>
                            <textarea
                                id="site_description"
                                name="site_description"
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >{{ old('site_description', $settings['site_description']) }}</textarea>
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon Kontak</label>
                            <input
                                type="text"
                                id="contact_phone"
                                name="contact_phone"
                                value="{{ old('contact_phone', $settings['contact_phone']) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Contoh: +62 812-3456-7890"
                            >
                        </div>
                    </div>
                </div>

                <!-- Commerce Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-shopping-cart text-lg text-green-600"></i>
                        Pengaturan E-Commerce
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Mata Uang</label>
                            <select
                                id="currency"
                                name="currency"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required
                            >
                                <option value="IDR" {{ $settings['currency'] == 'IDR' ? 'selected' : '' }}>IDR - Rupiah</option>
                                <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>USD - Dollar</option>
                                <option value="EUR" {{ $settings['currency'] == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            </select>
                        </div>
                        <div>
                            <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">Pajak (%)</label>
                            <input
                                type="number"
                                id="tax_rate"
                                name="tax_rate"
                                value="{{ old('tax_rate', $settings['tax_rate']) }}"
                                step="0.01"
                                min="0"
                                max="100"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required
                            >
                        </div>
                        <div>
                            <label for="shipping_fee" class="block text-sm font-medium text-gray-700 mb-2">Biaya Pengiriman (Rp)</label>
                            <input
                                type="number"
                                id="shipping_fee"
                                name="shipping_fee"
                                value="{{ old('shipping_fee', $settings['shipping_fee']) }}"
                                min="0"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required
                            >
                        </div>
                    </div>
                </div>

                <!-- System Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-cog text-lg text-orange-600"></i>
                        Pengaturan Sistem
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="maintenance_mode"
                                name="maintenance_mode"
                                value="1"
                                {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded"
                            >
                            <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                                <span class="font-medium">Mode Maintenance</span>
                                <span class="text-gray-500 block">Aktifkan untuk menutup situs sementara</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold transition flex items-center gap-2">
                        <i class="ph ph-floppy-disk"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>