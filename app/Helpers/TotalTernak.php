<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\Ternak;
use App\Models\Peternak;
use App\Support\MutasiSchema;

class TotalTernak
{
    private static function get_total_query($y, $ft_kab_kota = null, $ft_kecamatan = null, $ft_desa_kel = null) {
        $q = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y);
        if($ft_kab_kota) $q->where('peternaks.kab_kota_id', $ft_kab_kota);
        if($ft_kecamatan) $q->where('peternaks.kecamatan_id', $ft_kecamatan);
        if($ft_desa_kel) $q->where('peternaks.desa_kel_id', $ft_desa_kel);

        $columns = MutasiSchema::animalColumns();
        $selects = [];
        foreach($columns as $col) {
            $selects[] = "SUM($col) as $col";
        }
        
        $result = (array)$q->selectRaw(implode(', ', $selects))->first();
        
        $total_ternak = [];
        foreach($columns as $col) {
            $total_ternak[$col] = intval($result[$col] ?? 0);
        }
        return $total_ternak;
    }

    public static function total_kolom_pr($y, $pt, $ft_kab_kota = null, $ft_kecamatan = null, $ft_desa_kel = null){ // provinsi
        if(empty($pt)) return self::empty_total();
        return self::get_total_query($y, $ft_kab_kota, $ft_kecamatan, $ft_desa_kel);
    }

    public static function total_kolom_kk($y, $ukk, $pt, $ft_kecamatan = null, $ft_desa_kel = null){ // kabupaten/kota
        if(empty($pt)) return self::empty_total();
        return self::get_total_query($y, $ukk, $ft_kecamatan, $ft_desa_kel);
    }

    public static function total_kolom_kc($y, $ukc, $pt, $ft_desa_kel = null){ // kecamatan
        if(empty($pt)) return self::empty_total();
        // Since it is kecamatan level, we must pass the user's kecamatan ID as $ft_kecamatan argument. We don't have kab kota id but we know kecamatan id.
        $kec = DB::table('kecamatans')->where('id', $ukc)->first();
        return self::get_total_query($y, $kec ? $kec->kab_kota_id : null, $ukc, $ft_desa_kel);
    }

    private static function empty_total() {
        $total_ternak = [];
        foreach(MutasiSchema::animalColumns() as $col) {
            $total_ternak[$col] = 0;
        }
        return $total_ternak;
    }
}
