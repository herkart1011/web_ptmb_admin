@extends('app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h2 class="text-white">Selamat Datang di PTMB-GantiMeter</h2>
                <p class="lead text-white">MASUK</p>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="text-center text-md-start me-md-4 d-flex align-items-center">
                            <img src="{{ asset('images/pdam.png') }}" alt="Logo PDAM" class="img-fluid mb-3 logo-pdam">
                        </div>
                        <div class="vr d-none d-md-block mx-3"></div>
                        <div class="w-100">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $err)
                                        <p>{{ $err }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <form action="{{ route('login.action') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nama Pengguna <span class="text-danger">*</span></label>
                                    <input id="username" class="form-control" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan Nama Pengguna" required />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                    <input id="password" class="form-control" type="password" name="password" placeholder="Masukkan Kata Sandi" required />
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-danger w-100" href="{{ route('home') }}">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-image: url('{{ asset('images/city_blue.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .text-center {
        margin-bottom: 2rem;
    }
    .text-center h2 {
        color: #fff;
    }
    .text-center p {
        color: #ddd;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: rgba(255, 255, 255, 0.9);
    }
    .card-body {
        padding: 2rem;
    }
    .alert {
        margin-bottom: 1rem;
    }
    .form-label {
        font-weight: 500;
    }
    .btn-primary {
        background-color: #0056b3;
        border-color: #004a99;
    }
    .btn-primary:hover {
        background-color: #004a99;
        border-color: #003d7a;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #c82333;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .logo-pdam {
        max-width: 140px;
        height: auto;
    }
    .vr {
        border-left: 2px solid #ddd;
        height: 100%;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #0056b3;
    }
    .form-control {
        border-radius: 5px;
    }
</style>
@endpush
