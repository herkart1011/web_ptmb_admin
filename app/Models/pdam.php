<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pdam extends Model
{
    use HasFactory;

    protected $table = 'pdam';
    protected $primaryKey = 'nosamw';
    public $incrementing = false;

    protected $fillable = [
        'nosamw',
        'namaktp',
        'alamatktp',
        'nobody_wml',
        'tanggal_penggantian',
        'nilaikubik',
        'nobody_wmb',
        'gambar',
        'latitude',
        'longitude',
        'nama_petugas',
        'kode_ptgs',
    ];
    public $timestamps = false;
}
