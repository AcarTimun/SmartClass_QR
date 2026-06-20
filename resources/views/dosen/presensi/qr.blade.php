@extends('layouts.dosen')

@section('content')

<div class="text-center mt-10">

    <h1 class="text-2xl font-bold mb-4">
        QR Presensi
    </h1>

    <div class="flex justify-center">
        {!! $qr !!}
    </div>

    <p class="mt-4 text-gray-600">
        Scan QR untuk presensi
    </p>

    <div class="mt-6">
        <form action="{{ route('dosen.presensi.tutup', $sesi->id) }}" method="POST" class="tutup-form">
            @csrf
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Tutup Presensi
            </button>
        </form>
    </div>
</div>
<script>
document.querySelectorAll('.tutup-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Tutup Presensi?',
            text: 'Mahasiswa tidak bisa absen lagi setelah ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, tutup',
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
