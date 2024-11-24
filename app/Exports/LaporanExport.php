<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function collection()
    {
        return collect($this->laporan)->map(function ($item) {
            return [
                $item->nosamw,
                $item->namaktp,
                $item->alamatktp,
                \Carbon\Carbon::parse($item->tanggal_penggantian)->format('d-m-Y'), 
                $item->nama_petugas,
                basename($item->gambar), 
                $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Sambungan',
            'Nama Pelanggan',
            'Alamat',
            'Tanggal Penggantian',
            'Petugas yang mengganti',
            'Nama File Gambar',
            'Status'
        ];
    }
}
