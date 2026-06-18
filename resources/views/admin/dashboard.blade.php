@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold">
        Dashboard Admin
    </h1>

    <p class="mt-2">
        Selamat datang, {{ auth()->user()->name }}
    </p>
@endsection