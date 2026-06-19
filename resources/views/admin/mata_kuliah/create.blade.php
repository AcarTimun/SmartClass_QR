@extends('layouts.admin')

@section('title', 'Tambah Mata Kuliah')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.mata_kuliah.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors shadow-sm border border-slate-100">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Mata Kuliah</h1>
            <p class="text-slate-500 mt-1">Tambahkan mata kuliah baru ke dalam sistem.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.mata_kuliah.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-1">
                    <x-input-label for="kode_mk" value="Kode Mata Kuliah" class="font-medium text-slate-700" />
                    <x-text-input id="kode_mk" class="block mt-2 w-full uppercase" type="text" name="kode_mk" :value="old('kode_mk')" required autofocus placeholder="Contoh: MK001" />
                    <x-input-error :messages="$errors->get('kode_mk')" class="mt-2" />
                </div>
                
                <div class="md:col-span-1">
                    <x-input-label for="sks" value="SKS" class="font-medium text-slate-700" />
                    <x-text-input id="sks" class="block mt-2 w-full" type="number" name="sks" min="1" max="6" :value="old('sks')" required placeholder="Contoh: 3" />
                    <x-input-error :messages="$errors->get('sks')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="nama_mk" value="Nama Mata Kuliah" class="font-medium text-slate-700" />
                <x-text-input id="nama_mk" class="block mt-2 w-full" type="text" name="nama_mk" :value="old('nama_mk')" required placeholder="Contoh: Pemrograman Web Lanjut" />
                <x-input-error :messages="$errors->get('nama_mk')" class="mt-2" />
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