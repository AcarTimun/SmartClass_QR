@extends('layouts.admin')

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

</div>

@endsection
