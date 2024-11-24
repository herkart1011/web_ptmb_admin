@extends('app')

@section('title', $title)

@section('content')
<div class="container mt-5">
    <h1 class="text-left mb-4">Edit Data Pengguna</h1>
    @if(session('success'))
        <div class="alert alert-success text-left">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <ul class="nav nav-tabs justify-content-left" id="editTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">Edit Data Personal</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="penggantian-tab" data-bs-toggle="tab" data-bs-target="#penggantian" type="button" role="tab" aria-controls="penggantian" aria-selected="false">Edit Data Penggantian</button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="editTabsContent">
        <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
            <div class="card shadow-sm p-4">
                <form action="{{ route('search-user') }}" method="GET" id="searchForm" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_username" name="search_username" placeholder="Masukkan Username" required>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>

                @if(session('user'))
                <div class="mt-4">
                    <h5>Data Pengguna</h5>
                    <form action="{{ route('update-data-personal') }}" method="POST" id="editForm" class="mt-3">
                        @csrf
                        @php $user = session('user'); @endphp
                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Perbarui Data</button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <div class="tab-pane fade" id="penggantian" role="tabpanel" aria-labelledby="penggantian-tab">
            <div class="card shadow-sm p-4">
                <form action="{{ route('search-pelanggan') }}" method="GET" id="searchPelangganForm" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_nomor_id_pelanggan" name="search_nomor_id_pelanggan" placeholder="Masukkan Nomor ID Pelanggan" required>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>

                @if(session('pelanggan'))
                <form action="{{ route('update-data-penggantian') }}" method="POST" id="editPelangganForm" class="mt-4">
                    @csrf
                    @php $pelanggan = session('pelanggan'); @endphp
                    <input type="hidden" name="nosamw" value="{{ $pelanggan->nosamw }}">
                    <div class="form-group mb-3">
                        <label for="namaktp" class="form-label">Nama KTP</label>
                        <input type="text" class="form-control" id="namaktp" name="namaktp" value="{{ $pelanggan->namaktp }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="alamatktp" class="form-label">Alamat KTP</label>
                        <input type="text" class="form-control" id="alamatktp" name="alamatktp" value="{{ $pelanggan->alamatktp }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nobody_wml" class="form-label">Nomor Body Water Meter Lama</label>
                        <input type="text" class="form-control" id="nobody_wml" name="nobody_wml" value="{{ $pelanggan->nobody_wml }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal_penggantian" class="form-label">Tanggal Penggantian</label>
                        <input type="text" class="form-control" id="tanggal_penggantian" name="tanggal_penggantian" value="{{ $pelanggan->tanggal_penggantian }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nilaikubik" class="form-label">Nilai Kubik</label>
                        <input type="text" class="form-control" id="nilaikubik" name="nilaikubik" value="{{ $pelanggan->nilaikubik }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nobody_wmb" class="form-label">Nomor Body Water Meter Baru</label>
                        <input type="text" class="form-control" id="nobody_wmb" name="nobody_wmb" value="{{ $pelanggan->nobody_wmb }}" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Perbarui Data Penggantian</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        .btn-custom {
            background-color: #40679E;
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #324f7c;
            color: #fff;
        }
        .alert {
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
        .nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
        }
        .tab-content {
            border: 1px solid #ddd;
            border-top: none;
            padding: 2rem;
            border-radius: 0 0 8px 8px;
            background-color: #f8f9fa;
        }
        .btn-primary, .btn-secondary, .btn-success {
            border-radius: 8px;
            padding: .75rem 1.5rem;
            font-size: 1rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var personalTab = document.getElementById('personal-tab');
            var personalContent = document.getElementById('personal');

            if (!sessionStorage.getItem('activeTab')) {
                personalTab.classList.add('active');
                personalContent.classList.add('show', 'active');
            }

            var triggerTabList = [].slice.call(document.querySelectorAll('#editTabs button'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)

                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                    sessionStorage.setItem('activeTab', triggerEl.getAttribute('id'));
                })
            })

            var activeTab = sessionStorage.getItem('activeTab');
            if (activeTab) {
                var activeTabEl = document.getElementById(activeTab);
                if (activeTabEl) {
                    var tabTrigger = new bootstrap.Tab(activeTabEl)
                    tabTrigger.show()
                }
            }
        });
    </script>
@endsection
