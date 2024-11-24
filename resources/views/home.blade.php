@extends('app')

@section('content')
<div class="container mt-5">
    @auth
    <!-- Konten untuk pengguna yang sudah login -->
    <div class="text-center mb-4">
        <h1 class="display-4">PTMB-GantiMeter</h1>
        <p class="lead">Selamat datang di aplikasi PTMB-GantiMeter</p>

        <!-- Cek apakah pengguna adalah admin (user_id 1) -->
        @if(Auth::user()->user_id === 1)
        <div class="alert alert-info mt-4">
            <h4 class="alert-heading">Selamat Datang, Admin!</h4>
            <p>Anda memiliki akses penuh untuk mengelola sistem ini. Silakan pilih opsi di menu untuk mulai menggunakan fitur admin.</p>
        </div>
        @else
        <div class="alert alert-success mt-4">
            <h4 class="alert-heading">Selamat Datang, {{ Auth::user()->name }}!</h4>
            <p>Anda sekarang dapat mengakses fitur-fitur yang tersedia untuk pengguna.</p>
        </div>
        @endif
    </div>
    @endauth

    <!-- Konten untuk pengguna yang belum login -->
    @guest
    <div class="text-center mb-4">
        <h1 class="display-4">PTMB-GantiMeter</h1>
        <p class="lead">Kelola penggantian Water Meter dengan mudah dan cepat</p>
    </div>
    <div class="d-flex justify-content-center">
        <div class="card p-4 shadow-sm" style="width: 400px;">
            <div class="card-body text-center">
                <ul class="list-unstyled mb-4">
                    <li><i class="bi bi-check-circle-fill text-success"></i>Laporan penggantian dengan pemantauan real-time</li>
                </ul>
                <div class="text-center">
                    <a class="btn btn-primary btn-lg mx-2" href="{{ route('login') }}">Masuk</a>
                    <a class="btn btn-info btn-lg mx-2" href="{{ route('register') }}">Daftar</a>
                </div>
            </div>
        </div>
    </div>
    @endguest
</div>
@endsection

@push('styles')
<style>
    .alert {
        border-radius: 5px;
    }
    .alert-heading {
        font-size: 1.5rem;
    }
</style>
@endpush