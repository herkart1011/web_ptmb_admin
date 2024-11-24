@extends('app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h2>Ubah Kata Sandi</h2>
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
                            <form action="{{ route('password.action') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                                    <input id="old_password" class="form-control" type="password" name="old_password" required placeholder="Masukkan Kata Sandi Saat Ini" />
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Kata Sandi Baru <span class="text-danger">*</span></label>
                                    <input id="new_password" class="form-control" type="password" name="new_password" required placeholder="Masukkan Kata Sandi Baru" />
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                                    <input id="new_password_confirmation" class="form-control" type="password" name="new_password_confirmation" required placeholder="Konfirmasi Kata Sandi Baru" />
                                </div>
                                <div class="text-center mb-3">
                                    <button class="btn btn-primary btn-lg w-100">Ubah Kata Sandi</button>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-danger btn-lg w-100" href="{{ route('home') }}">Kembali</a>
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
