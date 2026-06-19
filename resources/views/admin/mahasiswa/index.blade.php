@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Data Mahasiswa</h1>

    <a href="{{ route('admin.mahasiswa.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Mahasiswa
    </a>
</div>



<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">No</th>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">NIM</th>
            <th class="p-3 text-left">Kelas</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($mahasiswa as $item)
            <tr class="border-t">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $item->user->name }}</td>
                <td class="p-3">{{ $item->user->email }}</td>
                <td class="p-3">{{ $item->nim }}</td>
                <td class="p-3">{{ $item->kelas->nama_kelas }}</td>

                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.mahasiswa.edit', $item) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                        Edit
                    </a>

                    <form action="{{ route('admin.mahasiswa.destroy', $item) }}"
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
                <td colspan="6" class="p-3 text-center">
                    Belum ada data mahasiswa
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
                title: 'Hapus Data Mahasiswa ini?',
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
