@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.mahasiswa.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors shadow-sm border border-slate-100">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Mahasiswa</h1>
            <p class="text-slate-500 mt-1">Tambahkan data mahasiswa baru ke dalam sistem.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Informasi Akun -->
            <div class="pb-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="ph ph-user-circle text-sky-500"></i> Informasi Akun
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" value="Nama Lengkap" class="font-medium text-slate-700" />
                        <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="email" value="Email" class="font-medium text-slate-700" />
                        <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required placeholder="mahasiswa@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="password" value="Password" class="font-medium text-slate-700" />
                        <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Data Akademik -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="ph ph-graduation-cap text-sky-500"></i> Data Akademik
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="nim" value="NIM" class="font-medium text-slate-700" />
                        <x-text-input id="nim" class="block mt-2 w-full" type="text" name="nim" :value="old('nim')" required placeholder="Nomor Induk Mahasiswa" />
                        <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="prodi" value="Program Studi" class="font-medium text-slate-700" />
                        <select name="prodi" id="prodi" class="block mt-2 w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-slate-700">
                            <option value="">-- Pilih Prodi --</option>
                            <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Teknologi Informasi" {{ old('prodi') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                            <option value="Sistem Komputer" {{ old('prodi') == 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer</option>
                            <option value="Bisnis Digital" {{ old('prodi') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                            <option value="Teknologi Informatika" {{ old('prodi') == 'Teknologi Informatika' ? 'selected' : '' }}>Teknologi Informatika</option>
                        </select>
                        <x-input-error :messages="$errors->get('prodi')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="kelas_id" value="Kelas" class="font-medium text-slate-700" />
                        <select name="kelas_id" id="kelas_id" class="block mt-2 w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-slate-700">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kelas_id')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <x-primary-button>
                    <i class="ph ph-floppy-disk text-lg mr-2"></i>
                    Simpan Data
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

@endsection
