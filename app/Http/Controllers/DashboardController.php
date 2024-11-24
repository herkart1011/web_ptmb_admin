<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Statistik.
     *
     * @return \Illuminate\View\View
     */
    public function showStatistics()
    {
        $statusCounts = DB::table('pdam')
            ->select(DB::raw('IF(nobody_wmb IS NOT NULL, "Diperbaiki", "Belum Diperbaiki") as status'), DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Calculate total count
        $totalCount = DB::table('pdam')->count();

        $statusCounts = array_merge([
            'Diperbaiki' => 0,
            'Belum Diperbaiki' => 0
        ], $statusCounts);

        // Data for Merek WMB chart
        $merekWmbData = DB::table('pdam')
            ->select('merek_wmb', DB::raw('count(*) as total'))
            ->groupBy('merek_wmb')
            ->pluck('total', 'merek_wmb')
            ->toArray();

        $merekWmbLabels = array_keys($merekWmbData);
        $merekWmbData = array_values($merekWmbData);
        $merekWmbLabels[] = 'Total Keseluruhan Data'; // Add total label
        $merekWmbData[] = $totalCount; // Add total count

        // Data for Petugas chart
        $petugasData = DB::table('pdam')
            ->select('nama_petugas', DB::raw('count(*) as total'))
            ->groupBy('nama_petugas')
            ->pluck('total', 'nama_petugas')
            ->toArray();

        $petugasLabels = array_keys($petugasData);
        $petugasData = array_values($petugasData);
        $petugasLabels[] = 'Total Keseluruhan Data'; // Add total label
        $petugasData[] = $totalCount; // Add total count

        // Data for Nilai Kubik chart
        $nilaiKubikData = DB::table('pdam')
            ->select('nilaikubik', DB::raw('count(*) as total'))
            ->groupBy('nilaikubik')
            ->pluck('total', 'nilaikubik')
            ->toArray();

        $nilaiKubikLabels = array_keys($nilaiKubikData);
        $nilaiKubikData = array_values($nilaiKubikData);
        $nilaiKubikLabels[] = 'Total Keseluruhan Data'; // Add total label
        $nilaiKubikData[] = $totalCount; // Add total count

        return view('statistics', [
            'title' => 'Laporan Statistik',
            'statusCounts' => $statusCounts,
            'totalCount' => $totalCount,
            'merekWmbLabels' => $merekWmbLabels,
            'merekWmbData' => $merekWmbData,
            'petugasLabels' => $petugasLabels,
            'petugasData' => $petugasData,
            'nilaiKubikLabels' => $nilaiKubikLabels,
            'nilaiKubikData' => $nilaiKubikData,
        ]);
    }
}
