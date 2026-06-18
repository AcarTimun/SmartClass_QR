@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">
        Data Jadwal Kuliah
    </h1>

    <a href="{{ route('admin.jadwal_kuliah.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Jadwal
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="w-full bg-white rounded shadow overflow-hidden">

    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">No</th>
            <th class="p-3 text-left">Dosen</th>
            <th class="p-3 text-left">Mata Kuliah</th>
            <th class="p-3 text-left">Kelas</th>
            <th class="p-3 text-left">Hari</th>
            <th class="p-3 text-left">Jam</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @forelse($jadwalKuliah as $item)
            <tr class="border-t">

                <td class="p-3">
                    {{ $loop->iteration }}
                </td>

                <td class="p-3">
                    {{ $item->dosen->user->name }}
                </td>

                <td class="p-3">
                    <div>
                        {{ $item->mataKuliah->nama_mk }}
                    </div>

                    <small class="text-gray-500">
                        {{ $item->mataKuliah->kode_mk }}
                    </small>
                </td>

                <td class="p-3">
                    {{ $item->kelas->nama_kelas }}
                </td>

                <td class="p-3">
                    {{ $item->hari }}
                </td>

                <td class="p-3">
                    {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                </td>

                <td class="p-3 flex gap-2">

                    <a href="{{ route('admin.jadwal_kuliah.edit', $item) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                        Edit
                    </a>

                    <form action="{{ route('admin.jadwal_kuliah.destroy', $item) }}"
                          method="POST"
                          class="delete-form">

                        @csrf
                        @method('DELETE')

                        <button class="bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="p-3 text-center">
                    Belum ada data jadwal kuliah
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Jadwal Kuliah ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
