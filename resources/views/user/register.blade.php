@extends('app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h2>Daftar Akun</h2>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="text-center text-md-start me-md-4 d-flex align-items-center">
                            <img src="{{ asset('images/pdam.png') }}" alt="Logo PDAM" class="img-fluid mb-3 logo-pdam">
                        </div>
                        <div class="vr d-none d-md-block mx-3"></div>
                        <div class="w-100">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $err)
                                        <p>{{ $err }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <form action="{{ route('register.action') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nama Pengguna <span class="text-danger">*</span></label>
                                    <input id="username" class="form-control @error('username') is-invalid @enderror" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan Nama Pengguna" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Masukkan Kata Sandi" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                                    <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
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
        background: linear-gradient(to right, #00c6ff, #0072ff);
        color: #333;
        font-family: Arial, sans-serif;
    }
    .text-center {
        margin-bottom: 2rem;
    }
    .text-center h2 {
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .card-body {
        padding: 2rem;
    }
    .alert {
        margin-bottom: 1rem;
        border-radius: 5px;
    }
    .form-label {
        font-weight: 500;
    }
    .form-control {
        padding: .75rem 1.25rem;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #0056b3;
    }
    .btn-primary {
        background-color: #0056b3;
        border-color: #004a99;
        border-radius: 8px;
        font-weight: bold;
    }
    .btn-primary:hover {
        background-color: #004a99;
        border-color: #003d7a;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #c82333;
        border-radius: 8px;
        font-weight: bold;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .logo-pdam {
        max-width: 120px;
        height: auto;
    }
    .vr {
        border-left: 1px solid #ddd;
        height: 280px;
    }
</style>
@endpush
