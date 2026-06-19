<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Buat Akun Baru ✨</h2>
        <p class="text-slate-500 mt-2">Daftar sekarang untuk mulai mencatat presensi.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-medium text-slate-700" />
            <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-medium text-slate-700" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-medium text-slate-700" />

            <x-text-input id="password" class="block mt-2 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-medium text-slate-700" />

            <x-text-input id="password_confirmation" class="block mt-2 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-slate-500 mt-6">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition duration-200">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
