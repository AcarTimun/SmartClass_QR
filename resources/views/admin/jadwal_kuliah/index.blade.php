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
            <th class="p-3 text-left">Status Presensi</th>
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

                <td class="p-4 align-middle">
                    <div class="flex gap-3 items-center">
                        @if ($item->sesiPresensi && $item->sesiPresensi->isDibuka())
                            <a href="{{ route('admin.presensi.aktif', $item->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                Lihat QR
                            </a>
                        @else
                            <form action="{{ route('admin.presensi.buka', $item->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                    Buka Presensi
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.presensi.lihat', $item->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm">
                            Lihat Absensi
                        </a>

                        <a href="{{ route('admin.jadwal_kuliah.edit', $item) }}" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm" >
                            Edit
                        </a>

                        <form action="{{ route('admin.jadwal_kuliah.destroy', $item) }}"
                            method="POST"
                            class="delete-form">

                            @csrf
                            @method('DELETE')

                            <button class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Hapus
                            </button>

                        </form>
                    </div>



                </td>
                <td class="p-3">
                    @if ($item->sesiPresensi)
                        @php $status = $item->sesiPresensi->status_label; @endphp
                            <span class="
                                px-3 py-1 rounded-full text-xs font-semibold
                                {{ $status == 'Dibuka' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $status == 'Expired' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $status == 'Ditutup' ? 'bg-red-100 text-red-700' : '' }}
                            ">
                                {{ $status }}
                            </span>
                    @else
                        <span class="text-gray-400">Belum ada sesi</span>
                    @endif
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" class="p-3 text-center">
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
