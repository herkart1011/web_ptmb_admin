@extends('app')

@section('title', 'Peta')

@section('content')
    <h5>Peta Sebaran Gangguan Meter</h5>

    <div class="d-flex justify-content-between mb-3">
        <div id="badge-container">
            <span id="belum-diganti" class="badge bg-danger">Belum Diganti: 0</span>
            <span id="sudah-diganti" class="badge bg-success">Sudah Diganti: 0</span>
            <span id="total-data" class="badge bg-secondary">Total Data: {{ count($data) }}</span>
        </div>
        <div class="d-flex align-items-center">
            <div class="me-3">
                <input type="checkbox" id="use-merek-filter" class="form-check-input" aria-label="Gunakan Filter Merek">
            </div>
            <select id="merek-dropdown" class="form-select me-3" aria-label="Pilih Merek" disabled>
                <option value="" selected>Pilih Merek</option>
                <!-- Opsi merek akan ditambahkan dengan JavaScript -->
            </select>
            <div class="me-3">
                <input type="checkbox" id="use-status-filter" class="form-check-input" aria-label="Gunakan Filter Status" checked>
            </div>
            <select id="status-dropdown" class="form-select" aria-label="Filter Status">
                <option value="all" selected>Semua Status</option>
                <option value="replaced">Data Sudah Diganti</option>
                <option value="not-replaced">Data Belum Diganti</option>
            </select>
        </div>
    </div>
    
    <div id="map"></div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nomor Sambungan:</strong> <span id="detail-id"></span></p>
                    <p><strong>Nama:</strong> <span id="detail-nama"></span></p>
                    <p><strong>Alamat:</strong> <span id="detail-alamat"></span></p>
                    <p><strong>Nomor Body Water Meter Lama:</strong> <span id="detail-meter-lama"></span></p>
                    <p><strong>Nomor Body Water Meter Baru:</strong> <span id="detail-meter-baru"></span></p>
                    <p><strong>File Gambar:</strong> <span id="detail-gambar"></span></p>
                    <p><strong>Latitude:</strong> <span id="detail-lat"></span></p>
                    <p><strong>Longitude:</strong> <span id="detail-lng"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 480px;
            width: 100%;
        }
        .btn-custom {
            background-color: #40679E; 
            color: #fff; 
            border: none; 
        }
        .btn-custom:hover {
            background-color: #324f7c;
            color: #fff; 
        }
        .badge {
            font-size: 1rem;
            margin-right: 10px;
        }
        .badge-yellow {
            background-color: yellow;
            color: black;
        }
        .d-flex {
            display: flex;
        }
        .align-items-center {
            align-items: center;
        }
        .me-2, .me-3 {
            margin-right: 0.5rem;
        }
        .modal-lg {
            max-width: 600px; /* Atur lebar modal sesuai kebutuhan */
        }
        .modal-body {
            max-height: 400px; /* Atur tinggi maksimal modal */
            overflow-y: auto; /* Tambahkan scroll jika konten melebihi batas tinggi */
        }
    </style>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-1.241667, 116.851111], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">TelU</a>'
            }).addTo(map);

            var data = @json($data);
            var brands = @json($brands); // Asumsikan $brands berisi data merek water meter

            // Menambahkan opsi merek ke dropdown
            var merekDropdown = document.getElementById('merek-dropdown');
            brands.forEach(function(brand) {
                var option = document.createElement('option');
                option.value = brand;
                option.textContent = brand;
                merekDropdown.appendChild(option);
            });

            function updateMap(filteredData, useMerekFilter, selectedBrand) {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.CircleMarker) {
                        map.removeLayer(layer);
                    }
                });

                var jumlahBelumDiganti = 0;
                var jumlahSudahDiganti = 0;

                filteredData.forEach(function(item) {
                    var lat = item.latitude;
                    var lng = item.longitude;
                    var warna = useMerekFilter ? 'gray' : (item.nobody_wmb ? 'green' : 'red');
                    var status = item.nobody_wmb ? 'Sudah Diganti' : 'Belum Diganti';
                    var marker = L.circleMarker([lat, lng], {
                        color: warna,
                        radius: 8
                    }).addTo(map)
                    .bindPopup('<b>Rincian Sambungan</b><br>ID Pelanggan: ' + item.nosamw + '<br>Nama: ' + item.namaktp + '<br>Alamat: ' + item.alamatktp + '<br>Status: ' + status + '<br><button class="btn btn-info btn-sm mt-2" onclick="showDetail(\'' + item.nosamw + '\')">Detail</button>');

                    if (item.nobody_wmb) {
                        jumlahSudahDiganti++;
                    } else {
                        jumlahBelumDiganti++;
                    }
                });

                var sudahDigantiBadge = document.getElementById('sudah-diganti');
                var belumDigantiBadge = document.getElementById('belum-diganti');

                if (useMerekFilter) {
                    sudahDigantiBadge.classList.add('badge-yellow');
                    sudahDigantiBadge.textContent = 'Merek ' + selectedBrand + ': ' + jumlahSudahDiganti;
                    belumDigantiBadge.style.display = 'none';
                } else {
                    sudahDigantiBadge.classList.remove('badge-yellow');
                    sudahDigantiBadge.textContent = 'Sudah Diganti: ' + jumlahSudahDiganti;
                    belumDigantiBadge.style.display = 'inline';
                    belumDigantiBadge.textContent = 'Belum Diganti: ' + jumlahBelumDiganti;
                }
                // Jumlah total data tidak berubah, tetap sesuai dengan jumlah data dalam database
            }

            function updateDropdownState() {
                var useMerekFilter = document.getElementById('use-merek-filter').checked;
                var merekDropdown = document.getElementById('merek-dropdown');
                merekDropdown.disabled = !useMerekFilter;

                var useStatusFilter = document.getElementById('use-status-filter').checked;
                var statusDropdown = document.getElementById('status-dropdown');
                statusDropdown.disabled = !useStatusFilter;
            }

            function applyFilters() {
                var filterValue = document.getElementById('status-dropdown').value;
                var selectedBrand = document.getElementById('merek-dropdown').value;
                var useMerekFilter = document.getElementById('use-merek-filter').checked;
                var useStatusFilter = document.getElementById('use-status-filter').checked;

                var filteredData = data;
                
                if (useStatusFilter) {
                    filteredData = filteredData.filter(function(item) {
                        if (filterValue === 'replaced') {
                            return item.nobody_wmb;
                        } else if (filterValue === 'not-replaced') {
                            return !item.nobody_wmb;
                        }
                        return true; // Semua data jika filter status adalah 'all'
                    });
                }

                if (useMerekFilter) {
                    filteredData = filteredData.filter(function(item) {
                        return selectedBrand ? item.merek_wmb === selectedBrand : true;
                    });
                }

                updateMap(filteredData, useMerekFilter, selectedBrand);
            }

            function toggleCheckbox(checkboxId) {
                var checkbox = document.getElementById(checkboxId);
                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        document.querySelectorAll('input[type="checkbox"]').forEach(function(cb) {
                            if (cb.id !== checkboxId) {
                                cb.checked = false;
                            }
                        });
                        updateDropdownState();
                        applyFilters();
                    } else {
                        updateDropdownState();
                        applyFilters();
                    }
                });
            }

            toggleCheckbox('use-merek-filter');
            toggleCheckbox('use-status-filter');

            document.getElementById('status-dropdown').addEventListener('change', applyFilters);
            document.getElementById('merek-dropdown').addEventListener('change', applyFilters);

            // Terapkan filter dan perbarui dropdown saat halaman dimuat
            updateDropdownState();
            applyFilters();
        });

        function showDetail(id) {
            fetch(`/detail/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detail-id').textContent = data.nosamw;
                    document.getElementById('detail-nama').textContent = data.namaktp;
                    document.getElementById('detail-alamat').textContent = data.alamatktp;
                    document.getElementById('detail-meter-lama').textContent = data.nobody_wml;
                    document.getElementById('detail-meter-baru').textContent = data.nobody_wmb || 'Belum Diganti';
                    document.getElementById('detail-lat').textContent = data.latitude;
                    document.getElementById('detail-lng').textContent = data.longitude;
                    document.getElementById('detail-gambar').textContent = data.nama_gambar || 'Tidak ada gambar';
                    var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                    detailModal.show();
                })
                .catch(error => console.error('Error fetching details:', error));
        }
    </script>
@endsection
