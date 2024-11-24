<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF; // Pastikan untuk mengimpor PDF jika Anda menggunakan laravel-dompdf
use Maatwebsite\Excel\Facades\Excel; // Pastikan untuk mengimpor Excel
use App\Exports\LaporanExport; // Pastikan untuk mengimpor kelas LaporanExport

class ReportController extends Controller
{
    public function daily(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Default sort direction is ascending

        $laporan = DB::table('pdam')
            ->select('nosamw', 'namaktp', 'alamatktp', 'tanggal_penggantian', 'nama_petugas', 'gambar',
                     DB::raw('IF(nobody_wmb IS NOT NULL, "Sudah Diganti", "Belum Diganti") as status'))
            ->orderBy('tanggal_penggantian', $sort)
            ->get();

        // Hitung jumlah total, sudah diganti, dan belum diganti
        $totalCount = $laporan->count();
        $sudahDigantiCount = $laporan->where('status', 'Sudah Diganti')->count();
        $belumDigantiCount = $laporan->where('status', 'Belum Diganti')->count();
        $statusValue = null;

        return view('daily', compact('laporan', 'totalCount', 'sudahDigantiCount', 'belumDigantiCount', 'sort', 'statusValue'));
    }

    // Metode lainnya
    public function sortByStatus(Request $request, $status)
    {
        $sort = $request->input('sort', 'asc'); // Default sort direction is ascending
        $statusValue = ucfirst(str_replace('-', ' ', $status)); // Converts 'sudah-diganti' to 'Sudah Diganti' and 'belum-diganti' to 'Belum Diganti'
        
        $laporan = DB::table('pdam')
            ->select('nosamw', 'namaktp', 'alamatktp', 'tanggal_penggantian', 'nama_petugas', 'gambar',
                     DB::raw('IF(nobody_wmb IS NOT NULL, "Sudah Diganti", "Belum Diganti") as status'))
            ->having('status', '=', $statusValue)
            ->orderBy('tanggal_penggantian', $sort)
            ->get();

        // Hitung jumlah data yang relevan
        $count = $laporan->count();
        $totalCount = $count; // Set total count for consistency

        return view('daily', compact('laporan', 'statusValue', 'count', 'sort', 'totalCount'));
    }

    public function filterByTime(Request $request, $timeframe)
    {
        $sort = $request->input('sort', 'asc'); // Default sort direction is ascending

        $query = DB::table('pdam')
            ->select('nosamw', 'namaktp', 'alamatktp', 'tanggal_penggantian', 'nama_petugas', 'gambar',
                     DB::raw('IF(nobody_wmb IS NOT NULL, "Sudah Diganti", "Belum Diganti") as status'));

        // Filter berdasarkan timeframe
        switch ($timeframe) {
            case 'day':
                $query->whereDate('tanggal_penggantian', '=', Carbon::today()->toDateString());
                break;
            case 'week':
                $query->whereBetween('tanggal_penggantian', [Carbon::now()->subDays(7)->toDateString(), Carbon::now()->toDateString()]);
                break;
            case 'month':
                $query->whereMonth('tanggal_penggantian', '=', Carbon::now()->month)
                      ->whereYear('tanggal_penggantian', '=', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('tanggal_penggantian', '=', Carbon::now()->year);
                break;
        }

        $laporan = $query->orderBy('tanggal_penggantian', $sort)->get();

        // Hitung jumlah total, sudah diganti, dan belum diganti
        $totalCount = $laporan->count();
        $sudahDigantiCount = $laporan->where('status', 'Sudah Diganti')->count();
        $belumDigantiCount = $laporan->where('status', 'Belum Diganti')->count();
        $statusValue = null;

        return view('daily', compact('laporan', 'totalCount', 'sudahDigantiCount', 'belumDigantiCount', 'sort', 'timeframe', 'statusValue'));
    }

    public function filterByDate(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $laporan = DB::table('pdam')
            ->select('nosamw', 'namaktp', 'alamatktp', 'tanggal_penggantian', 'nama_petugas', 'gambar',
                     DB::raw('IF(nobody_wmb IS NOT NULL, "Sudah Diganti", "Belum Diganti") as status'))
            ->whereDate('tanggal_penggantian', '=', $tanggal)
            ->get();

        // Hitung jumlah data yang relevan
        $count = $laporan->count();
        $totalCount = $count;
        $statusValue = null;

        return view('daily', compact('laporan', 'count', 'tanggal', 'totalCount', 'statusValue'));
    }

    public function export(Request $request, $format)
    {
        $statusValue = $request->input('statusValue');
        $timeframe = $request->input('timeframe');
        $tanggal = $request->input('tanggal');
        $sort = $request->input('sort', 'asc');

        $query = DB::table('pdam')
            ->select('nosamw', 'namaktp', 'alamatktp', 'tanggal_penggantian', 'nama_petugas', 'gambar',
                     DB::raw('IF(nobody_wmb IS NOT NULL, "Sudah Diganti", "Belum Diganti") as status'));

        if ($statusValue) {
            $query->having('status', '=', $statusValue);
        }

        if ($timeframe) {
            switch ($timeframe) {
                case 'day':
                    $query->whereDate('tanggal_penggantian', '=', Carbon::today()->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('tanggal_penggantian', [Carbon::now()->subDays(7)->toDateString(), Carbon::now()->toDateString()]);
                    break;
                case 'month':
                    $query->whereMonth('tanggal_penggantian', '=', Carbon::now()->month)
                          ->whereYear('tanggal_penggantian', '=', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('tanggal_penggantian', '=', Carbon::now()->year);
                    break;
            }
        }

        if ($tanggal) {
            $query->whereDate('tanggal_penggantian', '=', $tanggal);
        }

        $laporan = $query->orderBy('tanggal_penggantian', $sort)->get();

        if ($format == 'pdf') {
            $pdf = PDF::loadView('laporan_pdf', compact('laporan'));
            return $pdf->download('laporan_penggantian.pdf');
        } elseif ($format == 'csv') {
            return Excel::download(new LaporanExport($laporan), 'laporan_penggantian.csv');
        }
    }

    public function searchById(Request $request)
{
    $nomorIdPelanggan = $request->input('nomor_id_pelanggan');

    $laporan = DB::table('pdam')
        ->select('nosamw', 'namaktp', 'alamatktp', 'tanggal_penggantian', 'nama_petugas', 'gambar',
                 DB::raw('IF(nobody_wmb IS NOT NULL, "Sudah Diganti", "Belum Diganti") as status'))
        ->where('nosamw', $nomorIdPelanggan)
        ->get();

    return view('searchid', compact('laporan'));
}
}
