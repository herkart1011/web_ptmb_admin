<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title', 'PTMB-GantiMeter')</title>
    <style>
        body {
            background-image: url('{{ asset('images/city_crop.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .navbar {
            margin-top: 0 !important;
        }

        .navbar-nav .nav-link {
            color: inherit;
            outline: none;
        }

        .navbar-nav .nav-link.active {
            background-color: inherit;
        }

        .navbar-nav .nav-link:hover {
            color: #0069D9;
            background-color: transparent;
            text-decoration: underline;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        .navbar-brand img {
            margin-right: 20px;
        }

        .navbar-secondary {
            box-shadow: none;
        }

        .navbar-dark.bg-custom {
            background-color: #40679E;
        }

        .navbar-light.bg-custom {
            background-color: #DDE6ED;
        }

        .navbar-nav .nav-item .nav-link#dashboardDropdown {
            margin-left: -10px;
        }

        #map {
            height: 480px;
        }

        .btn-primary {
            background-color: #40679E;
            border-color: #40679E;
        }

        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:hover {
            background-color: #40679E;
            border-color: #40679E;
            box-shadow: none;
        }
    </style>
    @yield('styles')
</head>

<body class="{{ Route::currentRouteName() }}">
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/pdam.png') }}" alt="Logo" style="height: 30px;">
                PERUMDA TIRTA MANUNTUNG BALIKPAPAN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} ({{ Auth::user()->getRole() }})
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @auth
    <nav class="navbar navbar-expand-lg navbar-light bg-custom">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown my-0">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="#" id="dashboardDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dashboard
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dashboardDropdown">
                            <li><a class="dropdown-item {{ request()->routeIs('statistics') ? 'active' : '' }}" href="{{ route('statistics') }}">Statistik</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Pengaturan</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('password') }}">Ubah Kata Sandi</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown my-0">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('report') ? 'active' : '' }}" href="#" id="reportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Laporan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportDropdown">
                            <li><a class="dropdown-item {{ request()->routeIs('searchid') ? 'active' : '' }}" href="{{ route('searchid') }}">Cari berdasarkan ID pelanggan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item {{ request()->routeIs('daily') ? 'active' : '' }}" href="{{ route('daily') }}">Penggantian secara real time</a></li>
                        </ul>
                    </li>
                    <li class="nav-item my-0">
                        <a class="nav-link {{ request()->routeIs('map') ? 'active' : '' }}" href="{{ route('map') }}">Peta</a>
                    </li>
                    <!-- Tambah Data -->
                    <li class="nav-item my-0">
                        <a class="nav-link {{ request()->routeIs('add-data') ? 'active' : '' }}" href="{{ route('add-data') }}">Tambah Data</a>
                    </li>
                    <!-- Edit Data -->
                    @if(Auth::user()->user_id === 1)
                    <li class="nav-item my-0">
                        <a class="nav-link {{ request()->routeIs('edit-data') ? 'active' : '' }}" href="{{ route('edit-data') }}">Edit Data</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @endauth
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e) {
                if (!$(this).next('ul').hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next("ul");
                $subMenu.toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });

                return false;
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
