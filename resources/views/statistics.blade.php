@extends('app')

@section('title', 'Statistik Harian')

@section('content')
    <h5>Statistik Penggantian</h5>
    <div class="mb-3">
        <select id="chartType" class="form-select">
            <!-- Opsi dropdown yang hanya menampilkan grafik yang memiliki data -->
            @if(!empty($statusCounts))
                <option value="status">Berdasarkan Status Penggantian</option>
            @endif
            @if(!empty($merekWmbData))
                <option value="merek_wmb">Berdasarkan Merek Water Meter</option>
            @endif
            @if(!empty($petugasData))
                <option value="petugas">Berdasarkan Nama Petugas</option>
            @endif
            @if(!empty($nilaiKubikData))
                <option value="nilai_kubik">Berdasarkan Nilai Kubik Terakhir</option>
            @endif
        </select>
    </div>
    <div style="width: 1300px; height: 470px; background-color: white; padding: 20px; border-radius: 10px;">
        <!-- Hanya menampilkan canvas yang memiliki data -->
        @if(!empty($statusCounts))
            <canvas id="statusChart" style="height: 100%; display: none;"></canvas>
        @endif
        @if(!empty($merekWmbData))
            <canvas id="merekWmbChart" style="height: 100%; display: none;"></canvas>
        @endif
        @if(!empty($petugasData))
            <canvas id="petugasChart" style="height: 100%; display: none;"></canvas>
        @endif
        @if(!empty($nilaiKubikData))
            <canvas id="nilaiKubikChart" style="height: 100%; display: none;"></canvas>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .form-select {
            width: 300px; /* Lebar dropdown yang diperpanjang */
            margin-bottom: 20px; /* Jarak bawah */
            font-size: 16px; /* Ukuran font */
            border: 1px solid #ced4da; /* Warna border */
            border-radius: 0.25rem; /* Sudut border */
            padding: 0.5rem 0.75rem; /* Padding */
            background-color: #ffffff; /* Warna latar belakang */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            /* Menambahkan efek transisi saat fokus */
        }
        
        .form-select:focus {
            border-color: #80bdff; /* Warna border saat fokus */
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25); /* Efek bayangan saat fokus */
        }

        /* CSS untuk menu dropdown */
        .form-select option {
            padding: 0.5rem 1rem; /* Padding untuk setiap item dropdown */
        }

        /* Menyesuaikan tampilan dropdown pada perangkat kecil */
        @media (max-width: 768px) {
            .form-select {
                width: 100%; /* Lebar penuh pada perangkat kecil */
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mendapatkan konteks grafik
            var statusCtx = document.getElementById('statusChart')?.getContext('2d');
            var merekWmbCtx = document.getElementById('merekWmbChart')?.getContext('2d');
            var petugasCtx = document.getElementById('petugasChart')?.getContext('2d');
            var nilaiKubikCtx = document.getElementById('nilaiKubikChart')?.getContext('2d');

            // Mendapatkan data dari Blade
            var totalCount = {{ $totalCount ?? 0 }};
            var hasStatusData = {!! !empty($statusCounts) ? 'true' : 'false' !!};
            var hasMerekWmbData = {!! !empty($merekWmbData) ? 'true' : 'false' !!};
            var hasPetugasData = {!! !empty($petugasData) ? 'true' : 'false' !!};
            var hasNilaiKubikData = {!! !empty($nilaiKubikData) ? 'true' : 'false' !!};

            var statusChart = null;
            var merekWmbChart = null;
            var petugasChart = null;
            var nilaiKubikChart = null;

            // Membuat grafik jika data tersedia
            if (hasStatusData && statusCtx) {
                statusChart = new Chart(statusCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Belum Diperbaiki', 'Diperbaiki', 'Total Keseluruhan Data'],
                        datasets: [{
                            label: 'Jumlah Data',
                            data: [
                                {{ $statusCounts['Belum Diperbaiki'] ?? 0 }},
                                {{ $statusCounts['Diperbaiki'] ?? 0 }},
                                totalCount
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(255, 159, 64, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 2,
                            borderRadius: 8,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }]
                    },
                    options: {
                        indexAxis: 'x',
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: '#ddd'
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#000',
                                anchor: 'end',
                                align: 'top',
                                offset: 5,
                                formatter: function(value) {
                                    return value;
                                },
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    },
                    plugins: [ChartDataLabels]
                });
            }

            if (hasMerekWmbData && merekWmbCtx) {
                merekWmbChart = new Chart(merekWmbCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($merekWmbLabels) !!},
                        datasets: [{
                            label: 'Jumlah Penggantian Berdasarkan Merek WMB',
                            data: {!! json_encode($merekWmbData) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: '#ddd'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#000',
                                anchor: 'end',
                                align: 'right',
                                offset: 5,
                                formatter: function(value) {
                                    return value;
                                },
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    },
                    plugins: [ChartDataLabels]
                });
            }

            if (hasPetugasData && petugasCtx) {
                petugasChart = new Chart(petugasCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($petugasLabels) !!},
                        datasets: [{
                            label: 'Jumlah Penggantian Berdasarkan Petugas',
                            data: {!! json_encode($petugasData) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: '#ddd'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#000',
                                anchor: 'end',
                                align: 'right',
                                offset: 5,
                                formatter: function(value) {
                                    return value;
                                },
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    },
                    plugins: [ChartDataLabels]
                });
            }

            if (hasNilaiKubikData && nilaiKubikCtx) {
                nilaiKubikChart = new Chart(nilaiKubikCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($nilaiKubikLabels) !!},
                        datasets: [{
                            label: 'Jumlah Penggantian',
                            data: {!! json_encode($nilaiKubikData) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                grid: {
                                    color: '#ddd'
                                }
                            },
                            y: {
                                grid: {
                                    color: '#ddd'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#000',
                                anchor: 'end',
                                align: 'top',
                                offset: 5,
                                formatter: function(value) {
                                    return value;
                                },
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    },
                    plugins: [ChartDataLabels]
                });
            }

            // Menangani perubahan tipe grafik
            document.getElementById('chartType').addEventListener('change', function (event) {
                var selectedType = event.target.value;
                // Menyembunyikan semua grafik
                if (statusCtx) statusCtx.canvas.style.display = 'none';
                if (merekWmbCtx) merekWmbCtx.canvas.style.display = 'none';
                if (petugasCtx) petugasCtx.canvas.style.display = 'none';
                if (nilaiKubikCtx) nilaiKubikCtx.canvas.style.display = 'none';

                // Menampilkan grafik yang dipilih
                if (selectedType === 'status' && statusChart) {
                    statusCtx.canvas.style.display = 'block';
                } else if (selectedType === 'merek_wmb' && merekWmbChart) {
                    merekWmbCtx.canvas.style.display = 'block';
                } else if (selectedType === 'petugas' && petugasChart) {
                    petugasCtx.canvas.style.display = 'block';
                } else if (selectedType === 'nilai_kubik' && nilaiKubikChart) {
                    nilaiKubikCtx.canvas.style.display = 'block';
                }
            });

            // Menetapkan tampilan awal grafik
            document.getElementById('chartType').dispatchEvent(new Event('change'));
        });
    </script>
@endsection
