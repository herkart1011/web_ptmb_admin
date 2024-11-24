<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penggantian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Penggantian</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Sambungan</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Tanggal Penggantian</th>
                <th>Petugas yang mengganti</th>
                <th>Nama File Gambar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nosamw }}</td>
                    <td>{{ $item->namaktp }}</td>
                    <td>{{ $item->alamatktp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_penggantian)->format('d-m-Y') }}</td>
                    <td>{{ $item->nama_petugas }}</td>
                    <td>{{ basename($item->gambar) }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
