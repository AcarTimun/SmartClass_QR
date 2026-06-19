@extends('layouts.admin')

@section('title', 'Tambah Dosen')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.dosen.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors shadow-sm border border-slate-100">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Dosen</h1>
            <p class="text-slate-500 mt-1">Tambahkan data dosen baru ke dalam sistem.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.dosen.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input-label for="name" value="Nama Lengkap" class="font-medium text-slate-700" />
                    <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Dr. Budi Santoso, M.Kom." />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="md:col-span-1">
                    <x-input-label for="nidn" value="NIDN" class="font-medium text-slate-700" />
                    <x-text-input id="nidn" class="block mt-2 w-full" type="text" name="nidn" :value="old('nidn')" required placeholder="Nomor Induk Dosen Nasional" />
                    <x-input-error :messages="$errors->get('nidn')" class="mt-2" />
                </div>
                
                <div class="md:col-span-1">
                    <x-input-label for="email" value="Email" class="font-medium text-slate-700" />
                    <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required placeholder="dosen@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="password" value="Password" class="font-medium text-slate-700" />
                    <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <x-primary-button>
                    <i class="ph ph-floppy-disk text-lg mr-2"></i>
                    Simpan Data
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

@endsection
