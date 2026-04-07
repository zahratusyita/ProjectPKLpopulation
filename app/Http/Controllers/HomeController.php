<?php

namespace App\Http\Controllers;

use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Peternak;
use App\Models\Ternak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){
            if(session()->get('tahun_data') != ''){
                $now = session()->get('tahun_data');
                $user_type = Auth::user()->user_type;

                if($user_type == "A"){
                    $peternak = Peternak::all();
                    if(!empty($peternak)){
                        $sapi = Ternak::where('tahun', $now)
                            ->sum(DB::raw('sapi_anak_jantan + sapi_anak_betina + sapi_muda_jantan + sapi_muda_betina + sapi_dewasa_jantan + sapi_dewasa_betina'));  
                        $kerbau = Ternak::where('tahun', $now)
                            ->sum(DB::raw('kerbau_anak_jantan + kerbau_anak_betina + kerbau_muda_jantan + kerbau_muda_betina + kerbau_dewasa_jantan + kerbau_dewasa_betina'));
                        $kuda = Ternak::where('tahun', $now)
                            ->sum(DB::raw('kuda_anak_jantan + kuda_anak_betina + kuda_muda_jantan + kuda_muda_betina + kuda_dewasa_jantan + kuda_dewasa_betina'));
                        $kambing = Ternak::where('tahun', $now)
                            ->sum(DB::raw('kambing_anak_jantan + kambing_anak_betina + kambing_muda_jantan + kambing_muda_betina + kambing_dewasa_jantan + kambing_dewasa_betina'));
                        $babi = Ternak::where('tahun', $now)
                            ->sum(DB::raw('babi_anak_jantan + babi_anak_betina + babi_muda_jantan + babi_muda_betina + babi_dewasa_jantan + babi_dewasa_betina'));
                        $domba = Ternak::where('tahun', $now)
                            ->sum(DB::raw('domba_anak_jantan + domba_anak_betina + domba_muda_jantan + domba_muda_betina + domba_dewasa_jantan + domba_dewasa_betina'));
                        $ayam_ras = Ternak::where('tahun', $now)->sum('ayam_ras');
                        $ayam_buras = Ternak::where('tahun', $now)->sum('ayam_buras');   
                        $ayam_petelur = Ternak::where('tahun', $now)->sum('ayam_petelur');
                        $itik = Ternak::where('tahun', $now)->sum('itik'); 
                        $puyuh = Ternak::where('tahun', $now)->sum('puyuh');
                    }else{
                        $sapi = 0;
                        $kerbau = 0;
                        $kuda = 0;
                        $kambing = 0;
                        $babi = 0;
                        $domba = 0;
                        $ayam_ras = 0;
                        $ayam_buras = 0;
                        $ayam_petelur = 0;
                        $itik = 0;
                        $puyuh = 0;
                    }
                }elseif($user_type == "B"){
                    $user_kab_kota = Auth::user()->kab_kota_id;
                    $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                    $peternak = Peternak::where('kab_kota_id', $user_kab_kota)->get();
                    if(!empty($peternak)){
                        $sapi = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('sapi_anak_jantan + sapi_anak_betina + sapi_muda_jantan + sapi_muda_betina + sapi_dewasa_jantan + sapi_dewasa_betina'));
                        $kerbau = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('kerbau_anak_jantan + kerbau_anak_betina + kerbau_muda_jantan + kerbau_muda_betina + kerbau_dewasa_jantan + kerbau_dewasa_betina'));
                        $kuda = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('kuda_anak_jantan + kuda_anak_betina + kuda_muda_jantan + kuda_muda_betina + kuda_dewasa_jantan + kuda_dewasa_betina'));
                        $kambing = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('kambing_anak_jantan + kambing_anak_betina + kambing_muda_jantan + kambing_muda_betina + kambing_dewasa_jantan + kambing_dewasa_betina'));
                        $babi = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('babi_anak_jantan + babi_anak_betina + babi_muda_jantan + babi_muda_betina + babi_dewasa_jantan + babi_dewasa_betina'));
                        $domba = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('domba_anak_jantan + domba_anak_betina + domba_muda_jantan + domba_muda_betina + domba_dewasa_jantan + domba_dewasa_betina'));
                        $ayam_ras = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('ayam_ras'));
                        $ayam_buras = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('ayam_buras'));
                        $ayam_petelur = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('ayam_petelur'));
                        $itik = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('itik'));
                        $puyuh = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kab_kota_id', $user_kab_kota)
                            ->sum(DB::raw('puyuh'));
                    }else{
                        $sapi = 0;
                        $kerbau = 0;
                        $kuda = 0;
                        $kambing = 0;
                        $babi = 0;
                        $domba = 0;
                        $ayam_ras = 0;
                        $ayam_buras = 0;
                        $ayam_petelur = 0;
                        $itik = 0;
                        $puyuh = 0;
                    }
                }elseif($user_type == "C"){
                    $user_kab_kota = Auth::user()->kab_kota_id;
                    $user_kecamatan = Auth::user()->kecamatan_id;
                    $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                    $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
                    $peternak = Peternak::where('kecamatan_id', $user_kecamatan)->get();
                    if(!empty($peternak)){
                        $sapi = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('sapi_anak_jantan + sapi_anak_betina + sapi_muda_jantan + sapi_muda_betina + sapi_dewasa_jantan + sapi_dewasa_betina'));
                        $kerbau = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('kerbau_anak_jantan + kerbau_anak_betina + kerbau_muda_jantan + kerbau_muda_betina + kerbau_dewasa_jantan + kerbau_dewasa_betina'));
                        $kuda = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('kuda_anak_jantan + kuda_anak_betina + kuda_muda_jantan + kuda_muda_betina + kuda_dewasa_jantan + kuda_dewasa_betina'));
                        $kambing = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('kambing_anak_jantan + kambing_anak_betina + kambing_muda_jantan + kambing_muda_betina + kambing_dewasa_jantan + kambing_dewasa_betina'));
                        $babi = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('babi_anak_jantan + babi_anak_betina + babi_muda_jantan + babi_muda_betina + babi_dewasa_jantan + babi_dewasa_betina'));
                        $domba = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('domba_anak_jantan + domba_anak_betina + domba_muda_jantan + domba_muda_betina + domba_dewasa_jantan + domba_dewasa_betina'));
                        $ayam_ras = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('ayam_ras'));
                        $ayam_buras = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('ayam_buras'));
                        $ayam_petelur = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('ayam_petelur'));
                        $itik = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('itik'));
                        $puyuh = DB::table('peternaks')
                            ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                            ->where('ternaks.tahun', $now)->where('peternaks.kecamatan_id', $user_kecamatan)
                            ->sum(DB::raw('puyuh'));
                    }else{
                        $sapi = 0;
                        $kerbau = 0;
                        $kuda = 0;
                        $kambing = 0;
                        $babi = 0;
                        $domba = 0;
                        $ayam_ras = 0;
                        $ayam_buras = 0;
                        $ayam_petelur = 0;
                        $itik = 0;
                        $puyuh = 0;
                    }
                }
                return view('admin.home', ['sapi' => $sapi, 'kerbau' => $kerbau, 'kuda' => $kuda, 'kambing' => $kambing, 'babi' => $babi, 'domba' => $domba, 'ayam_ras' => $ayam_ras, 'ayam_buras' => $ayam_buras, 'ayam_petelur' => $ayam_petelur, 'itik' => $itik, 'puyuh' => $puyuh]);
            }else{
                return $this->tahun_data();
            }
        }else{
            echo('User is not authenticated');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function panduan()
    {
        if(Auth::check()){
            return view('admin/panduan');
        }else{
            echo('User is not authenticated');
        }
    }

    public function tahun_data()
    {
        if(Auth::check()){
            return view('admin/tahun_data');
        }else{
            echo('User is not authenticated');
        }
    }

    public function tahun_data_store(Request $request)
    {
        if(Auth::check()){
            session()->put('tahun_data', $request->tahun);
            return $this->index();
        }else{
            echo('User is not authenticated');
        }
    }
}
