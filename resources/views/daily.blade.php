@extends('app')

@section('title', 'Laporan Harian')

@section('content')
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h5 class="text-align-center">Laporan Penggantian Secara Real-Time</h5>
            
            @if (is_null($statusValue))
                <div class="mb-3">
                    <p>Total Laporan Pelanggan: {{ $totalCount }}</p>
                </div>
            @endif
        </div>

        <!-- Toolbar -->
        <div class="d-flex flex-wrap justify-content-center mb-3">
            <a href="{{ route('daily') }}" class="btn btn-custom {{ is_null($statusValue) ? 'active' : '' }}">Seluruh Data</a>

            <div class="dropdown mx-2">
                <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownStatus" data-bs-toggle="dropdown" aria-expanded="false">
                    Berdasarkan Status
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownStatus">
                    <li><a class="dropdown-item {{ request()->is('report/daily/sort/sudah-diganti') ? 'active' : '' }}" href="{{ route('daily.sort', 'sudah-diganti') }}">Sudah Diganti</a></li>
                    <li><a class="dropdown-item {{ request()->is('report/daily/sort/belum-diganti') ? 'active' : '' }}" href="{{ route('daily.sort', 'belum-diganti') }}">Belum Diganti</a></li>
                </ul>
            </div>

            <div class="dropdown mx-2">
                <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownTimeframe" data-bs-toggle="dropdown" aria-expanded="false">
                    Berdasarkan Waktu
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownTimeframe">
                    <li><a class="dropdown-item {{ request()->is('report/filter/day') ? 'active' : '' }}" href="{{ route('filterByTime', ['timeframe' => 'day', 'sort' => request('sort', 'asc') == 'asc' ? 'desc' : 'asc']) }}">Per Hari</a></li>
                    <li><a class="dropdown-item {{ request()->is('report/filter/week') ? 'active' : '' }}" href="{{ route('filterByTime', ['timeframe' => 'week', 'sort' => request('sort', 'asc') == 'asc' ? 'desc' : 'asc']) }}">Per Minggu</a></li>
                    <li><a class="dropdown-item {{ request()->is('report/filter/month') ? 'active' : '' }}" href="{{ route('filterByTime', ['timeframe' => 'month', 'sort' => request('sort', 'asc') == 'asc' ? 'desc' : 'asc']) }}">Per Bulan</a></li>
                    <li><a class="dropdown-item {{ request()->is('report/filter/year') ? 'active' : '' }}" href="{{ route('filterByTime', ['timeframe' => 'year', 'sort' => request('sort', 'asc') == 'asc' ? 'desc' : 'asc']) }}">Per Tahun</a></li>
                </ul>
            </div>

            <button type="button" class="btn btn-custom mx-2" data-bs-toggle="modal" data-bs-target="#datePickerModal">
                Berdasarkan Tanggal
            </button>

            <div class="dropdown mx-2">
                <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownExport" data-bs-toggle="dropdown" aria-expanded="false">
                    Export Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownExport">
                    <li><a class="dropdown-item" href="{{ route('report.export', ['format' => 'pdf', 'statusValue' => $statusValue, 'timeframe' => request('timeframe'), 'tanggal' => request('tanggal'), 'sort' => request('sort')]) }}">Export PDF</a></li>
                    <li><a class="dropdown-item" href="{{ route('report.export', ['format' => 'csv', 'statusValue' => $statusValue, 'timeframe' => request('timeframe'), 'tanggal' => request('tanggal'), 'sort' => request('sort')]) }}">Export CSV</a></li>
                </ul>
            </div>
        </div>

        <div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="datePickerModalLabel">Pilih Tanggal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="datePickerForm" action="{{ route('filterByDate') }}" method="GET">
                            <div class="mb-3">
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" form="datePickerForm">Cari</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover mx-auto">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">No</th>
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
                    @forelse ($laporan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item->nosamw }}</td>
                            <td class="text-center">{{ $item->namaktp }}</td>
                            <td class="text-center">{{ $item->alamatktp }}</td>
                            <td class="text-center">
                                @if ($item->tanggal_penggantian)
                                    {{ \Carbon\Carbon::parse($item->tanggal_penggantian)->format('d-m-Y') }}
                                @else
                                    
                                @endif
                            </td>
                            <td class="text-center">{{ $item->nama_petugas }}</td>
                            <td class="text-center">
                                {{ basename($item->gambar) }}
                            </td>
                            <td class="text-center">{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @isset($count)
            <div class="mt-3">
                <p class="text-align-center">Jumlah Data: {{ $count }} {{ $statusValue }}</p>
            </div>
        @endisset
    </div>
@endsection

@section('styles')
    <style>
        .btn-custom {
            background-color: #40679E;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            margin: 5px;
        }
        .btn-custom:hover {
            background-color: #324f7c;
            color: #fff;
        }
        .btn-custom.active, .dropdown-item.active {
            background-color: #324f7c;
            color: #fff;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .thead-dark {
            background-color: #343a40;
            color: #fff;
        }
        .table {
            margin-top: 20px;
            background-color: #fff; /* Menambahkan background putih pada tabel */
        }
        .text-center {
            text-align: center;
        }
        .text-align-center {
            text-align: center;
        }
        .text-align-left {
            text-align: left;
        }
        .text-align-right {
            text-align: right;
        }
        .text-align-top {
            vertical-align: top;
        }
        .text-align-middle {
            vertical-align: middle;
        }
        .text-align-bottom {
            vertical-align: bottom;
        }
    </style>
@endsection
