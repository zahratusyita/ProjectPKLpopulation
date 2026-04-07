<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peternak extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kab_kota_id',
        'kecamatan_id',
        'desa_kel_id',
        'alamat',
        'hp',
        'pekerjaan'
    ];

    public function Ternak(){
        return $this->hasMany('App\Models\Ternak');
    }

    public function Kabupaten_kota(){
        return $this->belongsTo('App\Models\Kabupaten_kota');
    }

    public function Kecamatan(){
        return $this->belongsTo('App\Models\Kecamatan');
    }

    public function Desa_kelurahan(){
        return $this->belongsTo('App\Models\Desa_kelurahan');
    }
}
