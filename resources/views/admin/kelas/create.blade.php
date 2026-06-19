@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.kelas.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors shadow-sm border border-slate-100">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Kelas Baru</h1>
            <p class="text-slate-500 mt-1">Masukkan informasi kelas baru ke dalam sistem.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="nama_kelas" value="Nama Kelas" class="font-medium text-slate-700" />
                <x-text-input id="nama_kelas" class="block mt-2 w-full" type="text" name="nama_kelas" :value="old('nama_kelas')" required autofocus placeholder="Contoh: TI-3A" />
                <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
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