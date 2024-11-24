<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        $data = DB::table('pdam')->get();

        // Ambil daftar merek water meter
        $brands = DB::table('pdam')->distinct()->pluck('merek_wmb');

        return view('map', ['data' => $data, 'brands' => $brands]);
    }

    public function showDetail($id)
    {
        $detail = DB::table('pdam')->where('nosamw', $id)->first();

        if ($detail) {
            $detail->nama_gambar = $this->getNamaGambar($detail->gambar);
        }

        return response()->json($detail);
    }

    private function getNamaGambar($gambarBlob)
    {
        return $gambarBlob; 
    }
}
