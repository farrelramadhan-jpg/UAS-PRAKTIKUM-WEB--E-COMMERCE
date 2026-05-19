<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Lupa Password</h2>
        <p class="text-sm text-gray-500 mt-1">Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Kirim Link Reset Password') }}
            </x-primary-button>
        </div>

        <div class="pt-2 text-center text-sm text-gray-600">
            Kembali ke <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk</a>
        </div>
    </form>
</x-guest-layout>
