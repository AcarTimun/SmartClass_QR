@extends('layouts.mahasiswa')

@section('content')

<h1 class="text-2xl font-bold mb-6 text-center">
    Scan QR Presensi
</h1>

<div class="relative w-full max-w-md mx-auto">

    {{-- CAMERA --}}
    <div id="reader" class="rounded overflow-hidden"></div>

    {{-- OVERLAY BOX --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="w-64 h-64 border-4 border-white relative">

            {{-- SCAN LINE --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-green-400 animate-scan"></div>

        </div>
    </div>

</div>

{{-- SOUND --}}
<audio id="beep" src="https://www.soundjay.com/buttons/beep-07.mp3"></audio>

<style>
@keyframes scan {
    0% { top: 0; }
    100% { top: 100%; }
}

.animate-scan {
    animation: scan 2s linear infinite;
}
</style>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText) {
        // 🔊 bunyi beep
        document.getElementById('beep').play();

        // stop kamera biar ga scan terus
        html5QrCode.stop().then(() => {
            window.location.href = decodedText;
        });
    }

    const html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {

            let backCamera = devices.find(device =>
                device.label.toLowerCase().includes('back')
            );

            let cameraId = backCamera ? backCamera.id : devices[0].id;

            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess
            );

        }
    }).catch(err => {
        console.error(err);
    });
</script>

@endsection
