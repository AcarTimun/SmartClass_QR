@extends('layouts.dosen')

@section('content')

<div class="text-center mt-10">

    <h1 class="text-2xl font-bold mb-4">
        QR Presensi
    </h1>

    {{-- Countdown Timer --}}
    <div class="mb-4">
        <div id="countdown-container" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emerald-50 border border-emerald-200">
            <i class="ph ph-timer text-xl text-emerald-600"></i>
            <span id="countdown-text" class="text-lg font-bold text-emerald-700">--:--</span>
        </div>
        <p class="text-xs text-slate-400 mt-1">Sesi akan otomatis tertutup saat waktu habis</p>
    </div>

    <div class="flex justify-center">
        {!! $qr !!}
    </div>

    <p class="mt-4 text-gray-600">
        Scan QR untuk presensi
    </p>

    <div class="mt-6 flex justify-center gap-4">
        <a href="{{ route('dosen.presensi.lihat', ['jadwal' => $sesi->jadwal_kuliah_id, 'sesi_id' => $sesi->id]) }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
        <form id="tutup-form" action="{{ route('dosen.presensi.tutup', $sesi->id) }}" method="POST" class="tutup-form">
            @csrf
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Tutup Presensi
            </button>
        </form>
    </div>
</div>
<script>
// Countdown Timer
(function() {
    let remaining = {{ $remainingSeconds }};
    const countdownText = document.getElementById('countdown-text');
    const countdownContainer = document.getElementById('countdown-container');
    const tutupForm = document.getElementById('tutup-form');

    function updateCountdown() {
        if (remaining <= 0) {
            countdownText.textContent = '00:00';
            countdownContainer.classList.remove('bg-emerald-50', 'border-emerald-200');
            countdownContainer.classList.add('bg-red-50', 'border-red-200');
            countdownText.classList.remove('text-emerald-700');
            countdownText.classList.add('text-red-700');

            // Auto tutup presensi
            Swal.fire({
                icon: 'info',
                title: 'Waktu Habis',
                text: 'Sesi QR presensi telah berakhir. Presensi akan otomatis ditutup.',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl' }
            }).then(() => {
                tutupForm.submit();
            });
            return;
        }

        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        countdownText.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

        // Warna berubah jadi kuning kalau < 2 menit, merah kalau < 1 menit
        if (remaining <= 60) {
            countdownContainer.classList.remove('bg-emerald-50', 'border-emerald-200', 'bg-amber-50', 'border-amber-200');
            countdownContainer.classList.add('bg-red-50', 'border-red-200');
            countdownText.classList.remove('text-emerald-700', 'text-amber-700');
            countdownText.classList.add('text-red-700');
        } else if (remaining <= 120) {
            countdownContainer.classList.remove('bg-emerald-50', 'border-emerald-200');
            countdownContainer.classList.add('bg-amber-50', 'border-amber-200');
            countdownText.classList.remove('text-emerald-700');
            countdownText.classList.add('text-amber-700');
        }

        remaining--;
        setTimeout(updateCountdown, 1000);
    }

    updateCountdown();
})();

// Tutup presensi confirmation
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
