@extends('app')

@section('title', 'Tambah Data')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Tambah Data</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-light p-4 rounded">
        <form action="{{ route('add-data.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nosamw" class="form-label">Nomor Sambungan</label>
                <input type="text" class="form-control" id="nosamw" name="nosamw" placeholder="Masukkan Nomor Sambungan" required>
            </div>
            <div class="mb-3">
                <label for="namaktp" class="form-label">Nama KTP</label>
                <input type="text" class="form-control" id="namaktp" name="namaktp" placeholder="Masukkan Nama Sesuai KTP" required>
            </div>
            <div class="mb-3">
                <label for="alamatktp" class="form-label">Alamat KTP</label>
                <input type="text" class="form-control" id="alamatktp" name="alamatktp" placeholder="Masukkan Alamat Sesuai KTP" required>
            </div>
            <div class="mb-3">
                <label for="nobody_wml" class="form-label">No Body WML</label>
                <input type="text" class="form-control" id="nobody_wml" name="nobody_wml" placeholder="Masukkan No Body WML" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="number" step="any" class="form-control" id="latitude" name="latitude" placeholder="Masukkan Koordinat Latitude" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="number" step="any" class="form-control" id="longitude" name="longitude" placeholder="Masukkan Koordinat Longitude" required>
            </div>
            <div class="mb-3">
                <label for="kode_ptgs" class="form-label">Kode Petugas</label>
                <input type="number" class="form-control" id="kode_ptgs" name="kode_ptgs" placeholder="Masukkan Kode Petugas" required>
            </div>
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary px-5">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
