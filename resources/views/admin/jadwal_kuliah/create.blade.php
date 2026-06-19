@extends('layouts.admin')

@section('title', 'Tambah Jadwal Kuliah')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.jadwal_kuliah.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors shadow-sm border border-slate-100">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Jadwal Kuliah</h1>
            <p class="text-slate-500 mt-1">Atur jadwal perkuliahan baru untuk dosen dan mahasiswa.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.jadwal_kuliah.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Dosen & Mata Kuliah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                <div class="md:col-span-1">
                    <x-input-label for="dosen_id" value="Dosen Pengampu" class="font-medium text-slate-700" />
                    <select name="dosen_id" id="dosen_id" class="block mt-2 w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-slate-700" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->id }}" {{ old('dosen_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->user->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('dosen_id')" class="mt-2" />
                </div>

                <div class="md:col-span-1">
                    <x-input-label for="mata_kuliah_id" value="Mata Kuliah" class="font-medium text-slate-700" />
                    <select name="mata_kuliah_id" id="mata_kuliah_id" class="block mt-2 w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-slate-700" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach ($mataKuliah as $item)
                            <option value="{{ $item->id }}" {{ old('mata_kuliah_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_mk }} - {{ $item->nama_mk }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('mata_kuliah_id')" class="mt-2" />
                </div>
            </div>

            <!-- Kelas & Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="lg:col-span-2">
                    <x-input-label for="kelas_id" value="Kelas" class="font-medium text-slate-700" />
                    <select name="kelas_id" id="kelas_id" class="block mt-2 w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-slate-700" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kelas_id')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="hari" value="Hari" class="font-medium text-slate-700" />
                    <select name="hari" id="hari" class="block mt-2 w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-slate-700" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('hari')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="jam_mulai" value="Jam Mulai" class="font-medium text-slate-700" />
                    <x-text-input id="jam_mulai" class="block mt-2 w-full" type="time" name="jam_mulai" :value="old('jam_mulai')" required />
                    <x-input-error :messages="$errors->get('jam_mulai')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="jam_selesai" value="Jam Selesai" class="font-medium text-slate-700" />
                    <x-text-input id="jam_selesai" class="block mt-2 w-full" type="time" name="jam_selesai" :value="old('jam_selesai')" required />
                    <x-input-error :messages="$errors->get('jam_selesai')" class="mt-2" />
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <x-primary-button>
                    <i class="ph ph-floppy-disk text-lg mr-2"></i>
                    Simpan Jadwal
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

@endsection
