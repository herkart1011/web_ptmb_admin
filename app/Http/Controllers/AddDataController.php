<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pdam;

class AddDataController extends Controller
{
    public function index()
    {
        return view('add-data');
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'nosamw' => 'required|string|max:255',
            'namaktp' => 'required|string|max:255',
            'alamatktp' => 'required|string|max:255',
            'nobody_wml' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kode_ptgs' => 'required|integer',
        ]);

        // Simpan data baru ke tabel pdam
        pdam::create($request->all());

        return redirect()->route('add-data')->with('success', 'Data berhasil ditambahkan.');
    }
}

