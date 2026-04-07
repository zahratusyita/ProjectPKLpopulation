<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\Ternak;
use App\Models\Peternak;

class TotalTernak
{
    public static function total_kolom_pr($y, $pt){ // provinsi
        if(!empty($pt)){
            $sapi_anak_jantan = Ternak::where('tahun', $y)->sum(DB::raw('sapi_anak_jantan'));
            $sapi_anak_betina = Ternak::where('tahun', $y)->sum(DB::raw('sapi_anak_betina'));
            $sapi_muda_jantan = Ternak::where('tahun', $y)->sum(DB::raw('sapi_muda_jantan'));
            $sapi_muda_betina = Ternak::where('tahun', $y)->sum(DB::raw('sapi_muda_betina'));
            $sapi_dewasa_jantan = Ternak::where('tahun', $y)->sum(DB::raw('sapi_dewasa_jantan'));
            $sapi_dewasa_betina = Ternak::where('tahun', $y)->sum(DB::raw('sapi_dewasa_betina'));
            
            $kerbau_anak_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kerbau_anak_jantan'));
            $kerbau_anak_betina = Ternak::where('tahun', $y)->sum(DB::raw('kerbau_anak_betina'));
            $kerbau_muda_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kerbau_muda_jantan'));
            $kerbau_muda_betina = Ternak::where('tahun', $y)->sum(DB::raw('kerbau_muda_betina'));
            $kerbau_dewasa_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kerbau_dewasa_jantan'));
            $kerbau_dewasa_betina = Ternak::where('tahun', $y)->sum(DB::raw('kerbau_dewasa_betina'));

            $kuda_anak_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kuda_anak_jantan'));
            $kuda_anak_betina = Ternak::where('tahun', $y)->sum(DB::raw('kuda_anak_betina'));
            $kuda_muda_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kuda_muda_jantan'));
            $kuda_muda_betina = Ternak::where('tahun', $y)->sum(DB::raw('kuda_muda_betina'));
            $kuda_dewasa_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kuda_dewasa_jantan'));
            $kuda_dewasa_betina = Ternak::where('tahun', $y)->sum(DB::raw('kuda_dewasa_betina'));

            $kambing_anak_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kambing_anak_jantan'));
            $kambing_anak_betina = Ternak::where('tahun', $y)->sum(DB::raw('kambing_anak_betina'));
            $kambing_muda_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kambing_muda_jantan'));
            $kambing_muda_betina = Ternak::where('tahun', $y)->sum(DB::raw('kambing_muda_betina'));
            $kambing_dewasa_jantan = Ternak::where('tahun', $y)->sum(DB::raw('kambing_dewasa_jantan'));
            $kambing_dewasa_betina = Ternak::where('tahun', $y)->sum(DB::raw('kambing_dewasa_betina'));

            $babi_anak_jantan = Ternak::where('tahun', $y)->sum(DB::raw('babi_anak_jantan'));
            $babi_anak_betina = Ternak::where('tahun', $y)->sum(DB::raw('babi_anak_betina'));
            $babi_muda_jantan = Ternak::where('tahun', $y)->sum(DB::raw('babi_muda_jantan'));
            $babi_muda_betina = Ternak::where('tahun', $y)->sum(DB::raw('babi_muda_betina'));
            $babi_dewasa_jantan = Ternak::where('tahun', $y)->sum(DB::raw('babi_dewasa_jantan'));
            $babi_dewasa_betina = Ternak::where('tahun', $y)->sum(DB::raw('babi_dewasa_betina'));

            $domba_anak_jantan = Ternak::where('tahun', $y)->sum(DB::raw('domba_anak_jantan'));
            $domba_anak_betina = Ternak::where('tahun', $y)->sum(DB::raw('domba_anak_betina'));
            $domba_muda_jantan = Ternak::where('tahun', $y)->sum(DB::raw('domba_muda_jantan'));
            $domba_muda_betina = Ternak::where('tahun', $y)->sum(DB::raw('domba_muda_betina'));
            $domba_dewasa_jantan = Ternak::where('tahun', $y)->sum(DB::raw('domba_dewasa_jantan'));
            $domba_dewasa_betina = Ternak::where('tahun', $y)->sum(DB::raw('domba_dewasa_betina'));

            $ayam_ras = Ternak::where('tahun', $y)->sum('ayam_ras');
            $ayam_buras = Ternak::where('tahun', $y)->sum('ayam_buras');   
            $ayam_petelur = Ternak::where('tahun', $y)->sum('ayam_petelur');
            $itik = Ternak::where('tahun', $y)->sum('itik'); 
            $puyuh = Ternak::where('tahun', $y)->sum('puyuh');
        }else{
            $sapi_anak_jantan = 0;
            $sapi_anak_betina = 0;
            $sapi_muda_jantan = 0;
            $sapi_muda_betina = 0;
            $sapi_dewasa_jantan = 0;
            $sapi_dewasa_betina = 0;

            $kerbau_anak_jantan = 0;
            $kerbau_anak_betina = 0;
            $kerbau_muda_jantan = 0;
            $kerbau_muda_betina = 0;
            $kerbau_dewasa_jantan = 0;
            $kerbau_dewasa_betina = 0;

            $kuda_anak_jantan = 0;
            $kuda_anak_betina = 0;
            $kuda_muda_jantan = 0;
            $kuda_muda_betina = 0;
            $kuda_dewasa_jantan = 0;
            $kuda_dewasa_betina = 0;

            $kambing_anak_jantan = 0;
            $kambing_anak_betina = 0;
            $kambing_muda_jantan = 0;
            $kambing_muda_betina = 0;
            $kambing_dewasa_jantan = 0;
            $kambing_dewasa_betina = 0;

            $babi_anak_jantan = 0;
            $babi_anak_betina = 0;
            $babi_muda_jantan = 0;
            $babi_muda_betina = 0;
            $babi_dewasa_jantan = 0;
            $babi_dewasa_betina = 0;

            $domba_anak_jantan = 0;
            $domba_anak_betina = 0;
            $domba_muda_jantan = 0;
            $domba_muda_betina = 0;
            $domba_dewasa_jantan = 0;
            $domba_dewasa_betina = 0;
            
            $ayam_ras = 0;
            $ayam_buras = 0;
            $ayam_petelur = 0;
            $itik = 0;
            $puyuh = 0;
        }

        $total_ternak = [
            'sapi_anak_jantan'          => $sapi_anak_jantan,
            'sapi_anak_betina'          => $sapi_anak_betina,
            'sapi_muda_jantan'          => $sapi_muda_jantan,
            'sapi_muda_betina'          => $sapi_muda_betina,
            'sapi_dewasa_jantan'        => $sapi_dewasa_jantan,
            'sapi_dewasa_betina'        => $sapi_dewasa_betina,

            'kerbau_anak_jantan'        => $kerbau_anak_jantan,
            'kerbau_anak_betina'        => $kerbau_anak_betina,
            'kerbau_muda_jantan'        => $kerbau_muda_jantan,
            'kerbau_muda_betina'        => $kerbau_muda_betina,
            'kerbau_dewasa_jantan'      => $kerbau_dewasa_jantan,
            'kerbau_dewasa_betina'      => $kerbau_dewasa_betina,

            'kuda_anak_jantan'          => $kuda_anak_jantan,
            'kuda_anak_betina'          => $kuda_anak_betina,
            'kuda_muda_jantan'          => $kuda_muda_jantan,
            'kuda_muda_betina'          => $kuda_muda_betina,
            'kuda_dewasa_jantan'        => $kuda_dewasa_jantan,
            'kuda_dewasa_betina'        => $kuda_dewasa_betina,

            'kambing_anak_jantan'       => $kambing_anak_jantan,
            'kambing_anak_betina'       => $kambing_anak_betina,
            'kambing_muda_jantan'       => $kambing_muda_jantan,
            'kambing_muda_betina'       => $kambing_muda_betina,
            'kambing_dewasa_jantan'     => $kambing_dewasa_jantan,
            'kambing_dewasa_betina'     => $kambing_dewasa_betina,

            'babi_anak_jantan'          => $babi_anak_jantan,
            'babi_anak_betina'          => $babi_anak_betina,
            'babi_muda_jantan'          => $babi_muda_jantan,
            'babi_muda_betina'          => $babi_muda_betina,
            'babi_dewasa_jantan'        => $babi_dewasa_jantan,
            'babi_dewasa_betina'        => $babi_dewasa_betina,

            'domba_anak_jantan'          => $domba_anak_jantan,
            'domba_anak_betina'          => $domba_anak_betina,
            'domba_muda_jantan'          => $domba_muda_jantan,
            'domba_muda_betina'          => $domba_muda_betina,
            'domba_dewasa_jantan'        => $domba_dewasa_jantan,
            'domba_dewasa_betina'        => $domba_dewasa_betina,
            
            'ayam_ras'      => $ayam_ras,
            'ayam_buras'    => $ayam_buras,
            'ayam_petelur'  => $ayam_petelur,
            'itik'          => $itik,
            'puyuh'         => $puyuh
        ];

        return $total_ternak;
    }

    public static function total_kolom_kk($y, $ukk, $pt){ // kabupaten/kota
        if(!empty($pt)){
            $sapi_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('sapi_anak_jantan'));
            $sapi_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('sapi_anak_betina'));
            $sapi_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('sapi_muda_jantan'));
            $sapi_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('sapi_muda_betina'));
            $sapi_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('sapi_dewasa_jantan'));
            $sapi_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('sapi_dewasa_betina'));
            
            $kerbau_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kerbau_anak_jantan'));
            $kerbau_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kerbau_anak_betina'));
            $kerbau_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kerbau_muda_jantan'));
            $kerbau_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kerbau_muda_betina'));
            $kerbau_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kerbau_dewasa_jantan'));
            $kerbau_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kerbau_dewasa_betina'));

            $kuda_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kuda_anak_jantan'));
            $kuda_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kuda_anak_betina'));
            $kuda_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kuda_muda_jantan'));
            $kuda_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kuda_muda_betina'));
            $kuda_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kuda_dewasa_jantan'));
            $kuda_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kuda_dewasa_betina'));

            $kambing_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kambing_anak_jantan'));
            $kambing_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kambing_anak_betina'));
            $kambing_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kambing_muda_jantan'));
            $kambing_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kambing_muda_betina'));
            $kambing_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kambing_dewasa_jantan'));
            $kambing_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('kambing_dewasa_betina'));

            $babi_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('babi_anak_jantan'));
            $babi_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('babi_anak_betina'));
            $babi_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('babi_muda_jantan'));
            $babi_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('babi_muda_betina'));
            $babi_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('babi_dewasa_jantan'));
            $babi_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('babi_dewasa_betina'));

            $domba_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('domba_anak_jantan'));
            $domba_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('domba_anak_betina'));
            $domba_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('domba_muda_jantan'));
            $domba_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('domba_muda_betina'));
            $domba_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('domba_dewasa_jantan'));
            $domba_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('domba_dewasa_betina'));

            $ayam_ras = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('ayam_ras'));
            $ayam_buras = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('ayam_buras'));
            $ayam_petelur = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('ayam_petelur'));
            $itik = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('itik'));
            $puyuh = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kab_kota_id', $ukk)->sum(DB::raw('puyuh'));
        }else{
            $sapi_anak_jantan = 0;
            $sapi_anak_betina = 0;
            $sapi_muda_jantan = 0;
            $sapi_muda_betina = 0;
            $sapi_dewasa_jantan = 0;
            $sapi_dewasa_betina = 0;

            $kerbau_anak_jantan = 0;
            $kerbau_anak_betina = 0;
            $kerbau_muda_jantan = 0;
            $kerbau_muda_betina = 0;
            $kerbau_dewasa_jantan = 0;
            $kerbau_dewasa_betina = 0;

            $kuda_anak_jantan = 0;
            $kuda_anak_betina = 0;
            $kuda_muda_jantan = 0;
            $kuda_muda_betina = 0;
            $kuda_dewasa_jantan = 0;
            $kuda_dewasa_betina = 0;

            $kambing_anak_jantan = 0;
            $kambing_anak_betina = 0;
            $kambing_muda_jantan = 0;
            $kambing_muda_betina = 0;
            $kambing_dewasa_jantan = 0;
            $kambing_dewasa_betina = 0;

            $babi_anak_jantan = 0;
            $babi_anak_betina = 0;
            $babi_muda_jantan = 0;
            $babi_muda_betina = 0;
            $babi_dewasa_jantan = 0;
            $babi_dewasa_betina = 0;

            $domba_anak_jantan = 0;
            $domba_anak_betina = 0;
            $domba_muda_jantan = 0;
            $domba_muda_betina = 0;
            $domba_dewasa_jantan = 0;
            $domba_dewasa_betina = 0;
            
            $ayam_ras = 0;
            $ayam_buras = 0;
            $ayam_petelur = 0;
            $itik = 0;
            $puyuh = 0;
        }

        $total_ternak = [
            'sapi_anak_jantan'          => $sapi_anak_jantan,
            'sapi_anak_betina'          => $sapi_anak_betina,
            'sapi_muda_jantan'          => $sapi_muda_jantan,
            'sapi_muda_betina'          => $sapi_muda_betina,
            'sapi_dewasa_jantan'        => $sapi_dewasa_jantan,
            'sapi_dewasa_betina'        => $sapi_dewasa_betina,

            'kerbau_anak_jantan'        => $kerbau_anak_jantan,
            'kerbau_anak_betina'        => $kerbau_anak_betina,
            'kerbau_muda_jantan'        => $kerbau_muda_jantan,
            'kerbau_muda_betina'        => $kerbau_muda_betina,
            'kerbau_dewasa_jantan'      => $kerbau_dewasa_jantan,
            'kerbau_dewasa_betina'      => $kerbau_dewasa_betina,

            'kuda_anak_jantan'          => $kuda_anak_jantan,
            'kuda_anak_betina'          => $kuda_anak_betina,
            'kuda_muda_jantan'          => $kuda_muda_jantan,
            'kuda_muda_betina'          => $kuda_muda_betina,
            'kuda_dewasa_jantan'        => $kuda_dewasa_jantan,
            'kuda_dewasa_betina'        => $kuda_dewasa_betina,

            'kambing_anak_jantan'       => $kambing_anak_jantan,
            'kambing_anak_betina'       => $kambing_anak_betina,
            'kambing_muda_jantan'       => $kambing_muda_jantan,
            'kambing_muda_betina'       => $kambing_muda_betina,
            'kambing_dewasa_jantan'     => $kambing_dewasa_jantan,
            'kambing_dewasa_betina'     => $kambing_dewasa_betina,

            'babi_anak_jantan'          => $babi_anak_jantan,
            'babi_anak_betina'          => $babi_anak_betina,
            'babi_muda_jantan'          => $babi_muda_jantan,
            'babi_muda_betina'          => $babi_muda_betina,
            'babi_dewasa_jantan'        => $babi_dewasa_jantan,
            'babi_dewasa_betina'        => $babi_dewasa_betina,

            'domba_anak_jantan'          => $domba_anak_jantan,
            'domba_anak_betina'          => $domba_anak_betina,
            'domba_muda_jantan'          => $domba_muda_jantan,
            'domba_muda_betina'          => $domba_muda_betina,
            'domba_dewasa_jantan'        => $domba_dewasa_jantan,
            'domba_dewasa_betina'        => $domba_dewasa_betina,
            
            'ayam_ras'      => $ayam_ras,
            'ayam_buras'    => $ayam_buras,
            'ayam_petelur'  => $ayam_petelur,
            'itik'          => $itik,
            'puyuh'         => $puyuh
        ];

        return $total_ternak;
    }

    public static function total_kolom_kc($y, $ukc, $pt){ // kecamatan
        if(!empty($pt)){
            $sapi_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('sapi_anak_jantan'));
            $sapi_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('sapi_anak_betina'));
            $sapi_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('sapi_muda_jantan'));
            $sapi_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('sapi_muda_betina'));
            $sapi_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('sapi_dewasa_jantan'));
            $sapi_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('sapi_dewasa_betina'));
            
            $kerbau_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kerbau_anak_jantan'));
            $kerbau_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kerbau_anak_betina'));
            $kerbau_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kerbau_muda_jantan'));
            $kerbau_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kerbau_muda_betina'));
            $kerbau_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kerbau_dewasa_jantan'));
            $kerbau_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kerbau_dewasa_betina'));

            $kuda_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kuda_anak_jantan'));
            $kuda_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kuda_anak_betina'));
            $kuda_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kuda_muda_jantan'));
            $kuda_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kuda_muda_betina'));
            $kuda_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kuda_dewasa_jantan'));
            $kuda_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kuda_dewasa_betina'));

            $kambing_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kambing_anak_jantan'));
            $kambing_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kambing_anak_betina'));
            $kambing_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kambing_muda_jantan'));
            $kambing_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kambing_muda_betina'));
            $kambing_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kambing_dewasa_jantan'));
            $kambing_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('kambing_dewasa_betina'));

            $babi_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('babi_anak_jantan'));
            $babi_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('babi_anak_betina'));
            $babi_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('babi_muda_jantan'));
            $babi_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('babi_muda_betina'));
            $babi_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('babi_dewasa_jantan'));
            $babi_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('babi_dewasa_betina'));

            $domba_anak_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('domba_anak_jantan'));
            $domba_anak_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('domba_anak_betina'));
            $domba_muda_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('domba_muda_jantan'));
            $domba_muda_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('domba_muda_betina'));
            $domba_dewasa_jantan = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('domba_dewasa_jantan'));
            $domba_dewasa_betina = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('domba_dewasa_betina'));

            $ayam_ras = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('ayam_ras'));
            $ayam_buras = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('ayam_buras'));
            $ayam_petelur = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('ayam_petelur'));
            $itik = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('itik'));
            $puyuh = DB::table('peternaks')->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')->where('ternaks.tahun', $y)->where('peternaks.kecamatan_id', $ukc)->sum(DB::raw('puyuh'));
        }else{
            $sapi_anak_jantan = 0;
            $sapi_anak_betina = 0;
            $sapi_muda_jantan = 0;
            $sapi_muda_betina = 0;
            $sapi_dewasa_jantan = 0;
            $sapi_dewasa_betina = 0;

            $kerbau_anak_jantan = 0;
            $kerbau_anak_betina = 0;
            $kerbau_muda_jantan = 0;
            $kerbau_muda_betina = 0;
            $kerbau_dewasa_jantan = 0;
            $kerbau_dewasa_betina = 0;

            $kuda_anak_jantan = 0;
            $kuda_anak_betina = 0;
            $kuda_muda_jantan = 0;
            $kuda_muda_betina = 0;
            $kuda_dewasa_jantan = 0;
            $kuda_dewasa_betina = 0;

            $kambing_anak_jantan = 0;
            $kambing_anak_betina = 0;
            $kambing_muda_jantan = 0;
            $kambing_muda_betina = 0;
            $kambing_dewasa_jantan = 0;
            $kambing_dewasa_betina = 0;

            $babi_anak_jantan = 0;
            $babi_anak_betina = 0;
            $babi_muda_jantan = 0;
            $babi_muda_betina = 0;
            $babi_dewasa_jantan = 0;
            $babi_dewasa_betina = 0;

            $domba_anak_jantan = 0;
            $domba_anak_betina = 0;
            $domba_muda_jantan = 0;
            $domba_muda_betina = 0;
            $domba_dewasa_jantan = 0;
            $domba_dewasa_betina = 0;
            
            $ayam_ras = 0;
            $ayam_buras = 0;
            $ayam_petelur = 0;
            $itik = 0;
            $puyuh = 0;
        }

        $total_ternak = [
            'sapi_anak_jantan'          => $sapi_anak_jantan,
            'sapi_anak_betina'          => $sapi_anak_betina,
            'sapi_muda_jantan'          => $sapi_muda_jantan,
            'sapi_muda_betina'          => $sapi_muda_betina,
            'sapi_dewasa_jantan'        => $sapi_dewasa_jantan,
            'sapi_dewasa_betina'        => $sapi_dewasa_betina,

            'kerbau_anak_jantan'        => $kerbau_anak_jantan,
            'kerbau_anak_betina'        => $kerbau_anak_betina,
            'kerbau_muda_jantan'        => $kerbau_muda_jantan,
            'kerbau_muda_betina'        => $kerbau_muda_betina,
            'kerbau_dewasa_jantan'      => $kerbau_dewasa_jantan,
            'kerbau_dewasa_betina'      => $kerbau_dewasa_betina,

            'kuda_anak_jantan'          => $kuda_anak_jantan,
            'kuda_anak_betina'          => $kuda_anak_betina,
            'kuda_muda_jantan'          => $kuda_muda_jantan,
            'kuda_muda_betina'          => $kuda_muda_betina,
            'kuda_dewasa_jantan'        => $kuda_dewasa_jantan,
            'kuda_dewasa_betina'        => $kuda_dewasa_betina,

            'kambing_anak_jantan'       => $kambing_anak_jantan,
            'kambing_anak_betina'       => $kambing_anak_betina,
            'kambing_muda_jantan'       => $kambing_muda_jantan,
            'kambing_muda_betina'       => $kambing_muda_betina,
            'kambing_dewasa_jantan'     => $kambing_dewasa_jantan,
            'kambing_dewasa_betina'     => $kambing_dewasa_betina,

            'babi_anak_jantan'          => $babi_anak_jantan,
            'babi_anak_betina'          => $babi_anak_betina,
            'babi_muda_jantan'          => $babi_muda_jantan,
            'babi_muda_betina'          => $babi_muda_betina,
            'babi_dewasa_jantan'        => $babi_dewasa_jantan,
            'babi_dewasa_betina'        => $babi_dewasa_betina,

            'domba_anak_jantan'          => $domba_anak_jantan,
            'domba_anak_betina'          => $domba_anak_betina,
            'domba_muda_jantan'          => $domba_muda_jantan,
            'domba_muda_betina'          => $domba_muda_betina,
            'domba_dewasa_jantan'        => $domba_dewasa_jantan,
            'domba_dewasa_betina'        => $domba_dewasa_betina,
            
            'ayam_ras'      => $ayam_ras,
            'ayam_buras'    => $ayam_buras,
            'ayam_petelur'  => $ayam_petelur,
            'itik'          => $itik,
            'puyuh'         => $puyuh
        ];

        return $total_ternak;
    }
}