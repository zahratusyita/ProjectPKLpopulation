<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class MutasiTernak extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'tahun',
        'jenis_mutasi',
        'peternak_id',
        'sapi_anak_jantan',
        'sapi_anak_betina',
        'sapi_muda_jantan',
        'sapi_muda_betina',
        'sapi_dewasa_jantan',
        'sapi_dewasa_betina',
        'kerbau_anak_jantan',
        'kerbau_anak_betina',
        'kerbau_muda_jantan',
        'kerbau_muda_betina',
        'kerbau_dewasa_jantan',
        'kerbau_dewasa_betina',
        'kuda_anak_jantan',
        'kuda_anak_betina',
        'kuda_muda_jantan',
        'kuda_muda_betina',
        'kuda_dewasa_jantan',
        'kuda_dewasa_betina',
        'kambing_anak_jantan',
        'kambing_anak_betina',
        'kambing_muda_jantan',
        'kambing_muda_betina',
        'kambing_dewasa_jantan',
        'kambing_dewasa_betina',
        'babi_anak_jantan',
        'babi_anak_betina',
        'babi_muda_jantan',
        'babi_muda_betina',
        'babi_dewasa_jantan',
        'babi_dewasa_betina',
        'domba_anak_jantan',
        'domba_anak_betina',
        'domba_muda_jantan',
        'domba_muda_betina',
        'domba_dewasa_jantan',
        'domba_dewasa_betina',
        'ayam_ras',
        'ayam_buras',
        'ayam_petelur',
        'itik',
        'puyuh',
        'keterangan',
        'applied_to_ternak',
    ];

    public function Peternak(){
        return $this->belongsTo('App\Models\Peternak');
    }

    public function Desa_kelurahan(): HasOneThrough
    {
        return $this->hasOneThrough(Desa_kelurahan::class, Peternak::class, 'desa_kel_id', 'peternak_id', 'id', 'id');
    }
}
