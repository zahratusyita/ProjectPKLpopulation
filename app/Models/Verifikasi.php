<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_type',
        'tahun',
        'daerah',
        'status_pengajuan',
        'tanggal_pengajuan',
        'status_verifikasi',
        'tanggal_verifikasi',
        'catatan'
    ];
}
