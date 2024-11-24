@extends('app')

@section('title', 'Cari ID Pelanggan')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-center">Laporan Penggantian Berdasarkan Nomor Sambungan</h4>
                        <form action="{{ route('searchid.post') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" name="nomor_id_pelanggan" class="form-control" placeholder="Masukkan Nomor ID Pelanggan" required>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                        @if(isset($laporan) && count($laporan) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">Nomor Sambungan</th>
                                            <th class="text-center">Nama Pelanggan</th>
                                            <th class="text-center">Alamat</th>
                                            <th class="text-center">Tanggal Penggantian</th>
                                            <th class="text-center">Petugas</th>
                                            <th class="text-center">Bukti Penggantian</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $item)
                                            <tr>
                                                <td class="text-center vertical-align-middle">{{ $item->nosamw }}</td>
                                                <td class="text-center vertical-align-middle">{{ $item->namaktp }}</td>
                                                <td class="text-center vertical-align-middle">{{ $item->alamatktp }}</td>
                                                <td class="text-center vertical-align-middle">{{ $item->tanggal_penggantian }}</td>
                                                <td class="text-center vertical-align-middle">{{ $item->nama_petugas }}</td>
                                                <td class="text-center vertical-align-middle">
                                                    @if($item->gambar)
                                                        {{ basename($item->gambar) }} <!-- Menampilkan nama file gambar -->
                                                    @else
                                                        Tidak ada
                                                    @endif
                                                </td> 
                                                <td class="text-center vertical-align-middle">{{ $item->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif(isset($laporan))
                            <div class="alert alert-warning" role="alert">
                                Data tidak ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 10px;
            border: none;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #40679E;
            border-color: #40679E;
        }
        .btn-primary:hover {
            background-color: #324f7c;
            border-color: #324f7c;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .alert-warning {
            max-width: 500px;
            margin: auto;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: middle; /* Vertically centers the content in each cell */
        }
        .thead-dark th {
            background-color: #343a40;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #eaeaea;
        }
        .text-center {
            text-align: center;
        }
        .vertical-align-middle {
            vertical-align: middle;
        }
    </style>
@endsection
