<?php

namespace App\Http\Controllers;

use App\Imports\TernaksImport;
use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Peternak;
use App\Models\Ternak;
use App\Models\Verifikasi;
use App\Helpers\TotalTernak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TernakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(session()->get('tahun_data') != ''){
            $now = session()->get('tahun_data');
            $user_type = Auth::user()->user_type;

            if($user_type == "A"){
                $peternak = Peternak::all();
                $kab_kota = Kabupaten_kota::all();
                $kecamatan = Kecamatan::all();
                $desa_kel = Desa_kelurahan::all();
                if($peternak){
                    $ternak = DB::table('peternaks')
                        ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                        ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                        ->where('ternaks.tahun', $now)
                        ->paginate(25);
                }else{
                    echo "Tidak ada peternak";
                }
            }elseif($user_type == "B"){
                $user_kab_kota = Auth::user()->kab_kota_id;
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
                $desa_kel = Desa_kelurahan::all();
                $peternak = Peternak::where('kab_kota_id', $user_kab_kota)->get();
                $status_verifikasi = Verifikasi::where('daerah', $user_kab_kota)->where('tahun', $now)->where('data_type', 'B')->first();
                if($peternak){
                    $ternak = DB::table('peternaks')
                        ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                        ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                        ->where('ternaks.tahun', $now)
                        ->where('peternaks.kab_kota_id', $user_kab_kota)
                        ->paginate(25);
                }else{
                    echo "Tidak ada peternak";
                }
            }elseif($user_type == "C"){
                $user_kab_kota = Auth::user()->kab_kota_id;
                $user_kecamatan = Auth::user()->kecamatan_id;
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
                $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
                $peternak = Peternak::where('kecamatan_id', $user_kecamatan)->get();
                $status_verifikasi = Verifikasi::where('daerah', $user_kecamatan)->where('tahun', $now)->where('data_type', 'C')->first();
                if($peternak){
                    $ternak = DB::table('peternaks')
                        ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                        ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                        ->where('ternaks.tahun', $now)
                        ->where('peternaks.kecamatan_id', $user_kecamatan)
                        ->paginate(25);
                }else{
                    echo "Tidak ada peternak";
                }
            }

            if($user_type == 'B' OR $user_type == 'C'){
                if($status_verifikasi == ''){
                    $status_verifikasi = array(
                        'status_pengajuan' => 0,
                        'status_verifikasi' => 0,
                        'catatan' => ''
                    );
                }
                return view('admin.ternak.ternak', ['status_verifikasi'=>$status_verifikasi, 'ternak'=>$ternak, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel]);
            }else{
                return view('admin.ternak.ternak', ['ternak'=>$ternak, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel]);
            }
        }else{
            return view('admin.tahun_data');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatan = Auth::user()->kecamatan_id;
        $now = session()->get('tahun_data');
        if($kecamatan){
            $peternak = Peternak::select('id', 'nik', 'nama')
                ->where('kecamatan_id', $kecamatan)
                ->whereNotIn('id', Ternak::select('peternak_id')->where('tahun', $now))
                ->get();
        }
        return view('admin.ternak.form_ternak', ['peternak' => $peternak]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun'                 => 'numeric',
            'peternak_id'           => 'numeric',
            'sapi_anak_jantan'      => 'numeric|nullable',
            'sapi_anak_betina'      => 'numeric|nullable',
            'sapi_muda_jantan'      => 'numeric|nullable',
            'sapi_muda_betina'      => 'numeric|nullable',
            'sapi_dewasa_jantan'    => 'numeric|nullable',
            'sapi_dewasa_betina'    => 'numeric|nullable',
            'kerbau_anak_jantan'    => 'numeric|nullable',
            'kerbau_anak_betina'    => 'numeric|nullable',
            'kerbau_muda_jantan'    => 'numeric|nullable',
            'kerbau_muda_betina'    => 'numeric|nullable',
            'kerbau_dewasa_jantan'  => 'numeric|nullable',
            'kerbau_dewasa_betina'  => 'numeric|nullable',
            'kuda_anak_jantan'      => 'numeric|nullable',
            'kuda_anak_betina'      => 'numeric|nullable',
            'kuda_muda_jantan'      => 'numeric|nullable',
            'kuda_muda_betina'      => 'numeric|nullable',
            'kuda_dewasa_jantan'    => 'numeric|nullable',
            'kuda_dewasa_betina'    => 'numeric|nullable',

            'kambing_anak_jantan'   => 'numeric|nullable',
            'kambing_anak_betina'   => 'numeric|nullable',
            'kambing_muda_jantan'   => 'numeric|nullable',
            'kambing_muda_betina'   => 'numeric|nullable',
            'kambing_dewasa_jantan' => 'numeric|nullable',
            'kambing_dewasa_betina' => 'numeric|nullable',
            'babi_anak_jantan'      => 'numeric|nullable',
            'babi_anak_betina'      => 'numeric|nullable',
            'babi_muda_jantan'      => 'numeric|nullable',
            'babi_muda_betina'      => 'numeric|nullable',
            'babi_dewasa_jantan'    => 'numeric|nullable',
            'babi_dewasa_betina'    => 'numeric|nullable',
            'domba_anak_jantan'     => 'numeric|nullable',
            'domba_anak_betina'     => 'numeric|nullable',
            'domba_muda_jantan'     => 'numeric|nullable',
            'domba_muda_betina'     => 'numeric|nullable',
            'domba_dewasa_jantan'   => 'numeric|nullable',
            'domba_dewasa_betina'   => 'numeric|nullable',

            'ayam_ras'              => 'numeric|nullable',
            'ayam_buras'            => 'numeric|nullable',
            'ayam_petelur'          => 'numeric|nullable',
            'itik'                  => 'numeric|nullable',
            'puyuh'                 => 'numeric|nullable',

            'keterangan'            => 'regex:/^[a-zA-Z0-9.\s]+$/|nullable'
        ]);

        $init_val = 0;
        Ternak::create([
            'tahun'                 => session()->get('tahun_data'),
            'peternak_id'           => $request->peternak,
            'sapi_anak_jantan'      => $init_val + $request->sapi_anak_jantan,
            'sapi_anak_betina'      => $init_val + $request->sapi_anak_betina,
            'sapi_muda_jantan'      => $init_val + $request->sapi_muda_jantan,
            'sapi_muda_betina'      => $init_val + $request->sapi_muda_betina,
            'sapi_dewasa_jantan'    => $init_val + $request->sapi_dewasa_jantan,
            'sapi_dewasa_betina'    => $init_val + $request->sapi_dewasa_betina,
            'kerbau_anak_jantan'    => $init_val + $request->kerbau_anak_jantan,
            'kerbau_anak_betina'    => $init_val + $request->kerbau_anak_betina,
            'kerbau_muda_jantan'    => $init_val + $request->kerbau_muda_jantan,
            'kerbau_muda_betina'    => $init_val + $request->kerbau_muda_betina,
            'kerbau_dewasa_jantan'  => $init_val + $request->kerbau_dewasa_jantan,
            'kerbau_dewasa_betina'  => $init_val + $request->kerbau_dewasa_betina,
            'kuda_anak_jantan'      => $init_val + $request->kuda_anak_jantan,
            'kuda_anak_betina'      => $init_val + $request->kuda_anak_betina,
            'kuda_muda_jantan'      => $init_val + $request->kuda_muda_jantan,
            'kuda_muda_betina'      => $init_val + $request->kuda_muda_betina,
            'kuda_dewasa_jantan'    => $init_val + $request->kuda_dewasa_jantan,
            'kuda_dewasa_betina'    => $init_val + $request->kuda_dewasa_betina,

            'kambing_anak_jantan'   => $init_val + $request->kambing_anak_jantan,
            'kambing_anak_betina'   => $init_val + $request->kambing_anak_betina,
            'kambing_muda_jantan'   => $init_val + $request->kambing_muda_jantan,
            'kambing_muda_betina'   => $init_val + $request->kambing_muda_betina,
            'kambing_dewasa_jantan' => $init_val + $request->kambing_dewasa_jantan,
            'kambing_dewasa_betina' => $init_val + $request->kambing_dewasa_betina,
            'babi_anak_jantan'      => $init_val + $request->babi_anak_jantan,
            'babi_anak_betina'      => $init_val + $request->babi_anak_betina,
            'babi_muda_jantan'      => $init_val + $request->babi_muda_jantan,
            'babi_muda_betina'      => $init_val + $request->babi_muda_betina,
            'babi_dewasa_jantan'    => $init_val + $request->babi_dewasa_jantan,
            'babi_dewasa_betina'    => $init_val + $request->babi_dewasa_betina,
            'domba_anak_jantan'     => $init_val + $request->domba_anak_jantan,
            'domba_anak_betina'     => $init_val + $request->domba_anak_betina,
            'domba_muda_jantan'     => $init_val + $request->domba_muda_jantan,
            'domba_muda_betina'     => $init_val + $request->domba_muda_betina,
            'domba_dewasa_jantan'   => $init_val + $request->domba_dewasa_jantan,
            'domba_dewasa_betina'   => $init_val + $request->domba_dewasa_betina,

            'ayam_ras'              => $init_val + $request->ayam_ras,
            'ayam_buras'            => $init_val + $request->ayam_buras,
            'ayam_petelur'          => $init_val + $request->ayam_petelur,
            'itik'                  => $init_val + $request->itik,
            'puyuh'                 => $init_val + $request->puyuh,

            'keterangan'            => $request->keterangan
        ]);

        return redirect('ternak');
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
        $kecamatan = Auth::user()->kecamatan_id;
        $peternak = Peternak::where('kecamatan_id', $kecamatan)->get();
        $ternak = Ternak::find($id);
        return view('admin.ternak.edit_ternak', [
            'ternak'=>$ternak,
            'peternak'=>$peternak
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'sapi_anak_jantan'      => 'numeric|nullable',
            'sapi_anak_betina'      => 'numeric|nullable',
            'sapi_muda_jantan'      => 'numeric|nullable',
            'sapi_muda_betina'      => 'numeric|nullable',
            'sapi_dewasa_jantan'    => 'numeric|nullable',
            'sapi_dewasa_betina'    => 'numeric|nullable',
            'kerbau_anak_jantan'    => 'numeric|nullable',
            'kerbau_anak_betina'    => 'numeric|nullable',
            'kerbau_muda_jantan'    => 'numeric|nullable',
            'kerbau_muda_betina'    => 'numeric|nullable',
            'kerbau_dewasa_jantan'  => 'numeric|nullable',
            'kerbau_dewasa_betina'  => 'numeric|nullable',
            'kuda_anak_jantan'      => 'numeric|nullable',
            'kuda_anak_betina'      => 'numeric|nullable',
            'kuda_muda_jantan'      => 'numeric|nullable',
            'kuda_muda_betina'      => 'numeric|nullable',
            'kuda_dewasa_jantan'    => 'numeric|nullable',
            'kuda_dewasa_betina'    => 'numeric|nullable',

            'kambing_anak_jantan'   => 'numeric|nullable',
            'kambing_anak_betina'   => 'numeric|nullable',
            'kambing_muda_jantan'   => 'numeric|nullable',
            'kambing_muda_betina'   => 'numeric|nullable',
            'kambing_dewasa_jantan' => 'numeric|nullable',
            'kambing_dewasa_betina' => 'numeric|nullable',
            'babi_anak_jantan'      => 'numeric|nullable',
            'babi_anak_betina'      => 'numeric|nullable',
            'babi_muda_jantan'      => 'numeric|nullable',
            'babi_muda_betina'      => 'numeric|nullable',
            'babi_dewasa_jantan'    => 'numeric|nullable',
            'babi_dewasa_betina'    => 'numeric|nullable',
            'domba_anak_jantan'     => 'numeric|nullable',
            'domba_anak_betina'     => 'numeric|nullable',
            'domba_muda_jantan'     => 'numeric|nullable',
            'domba_muda_betina'     => 'numeric|nullable',
            'domba_dewasa_jantan'   => 'numeric|nullable',
            'domba_dewasa_betina'   => 'numeric|nullable',

            'ayam_ras'              => 'numeric|nullable',
            'ayam_buras'            => 'numeric|nullable',
            'ayam_petelur'          => 'numeric|nullable',
            'itik'                  => 'numeric|nullable',
            'puyuh'                 => 'numeric|nullable',

            'keterangan'            => 'regex:/^[a-zA-Z0-9.\s]+$/|nullable'
        ]);

        $ternak = Ternak::find($id);

        $ternak->sapi_anak_jantan      = $request->sapi_anak_jantan;
        $ternak->sapi_anak_betina      = $request->sapi_anak_betina;
        $ternak->sapi_muda_jantan      = $request->sapi_muda_jantan;
        $ternak->sapi_muda_betina      = $request->sapi_muda_betina;
        $ternak->sapi_dewasa_jantan    = $request->sapi_dewasa_jantan;
        $ternak->sapi_dewasa_betina    = $request->sapi_dewasa_betina;
        $ternak->kerbau_anak_jantan    = $request->kerbau_anak_jantan;
        $ternak->kerbau_anak_betina    = $request->kerbau_anak_betina;
        $ternak->kerbau_muda_jantan    = $request->kerbau_muda_jantan;
        $ternak->kerbau_muda_betina    = $request->kerbau_muda_betina;
        $ternak->kerbau_dewasa_jantan  = $request->kerbau_dewasa_jantan;
        $ternak->kerbau_dewasa_betina  = $request->kerbau_dewasa_betina;
        $ternak->kuda_anak_jantan      = $request->kuda_anak_jantan;
        $ternak->kuda_anak_betina      = $request->kuda_anak_betina;
        $ternak->kuda_muda_jantan      = $request->kuda_muda_jantan;
        $ternak->kuda_muda_betina      = $request->kuda_muda_betina;
        $ternak->kuda_dewasa_jantan    = $request->kuda_dewasa_jantan;
        $ternak->kuda_dewasa_betina    = $request->kuda_dewasa_betina;

        $ternak->kambing_anak_jantan   = $request->kambing_anak_jantan;
        $ternak->kambing_anak_betina   = $request->kambing_anak_betina;
        $ternak->kambing_muda_jantan   = $request->kambing_muda_jantan;
        $ternak->kambing_muda_betina   = $request->kambing_muda_betina;
        $ternak->kambing_dewasa_jantan = $request->kambing_dewasa_jantan;
        $ternak->kambing_dewasa_betina = $request->kambing_dewasa_betina;
        $ternak->babi_anak_jantan      = $request->babi_anak_jantan;
        $ternak->babi_anak_betina      = $request->babi_anak_betina;
        $ternak->babi_muda_jantan      = $request->babi_muda_jantan;
        $ternak->babi_muda_betina      = $request->babi_muda_betina;
        $ternak->babi_dewasa_jantan    = $request->babi_dewasa_jantan;
        $ternak->babi_dewasa_betina    = $request->babi_dewasa_betina;
        $ternak->domba_anak_jantan     = $request->domba_anak_jantan;
        $ternak->domba_anak_betina     = $request->domba_anak_betina;
        $ternak->domba_muda_jantan     = $request->domba_muda_jantan;
        $ternak->domba_muda_betina     = $request->domba_muda_betina;
        $ternak->domba_dewasa_jantan   = $request->domba_dewasa_jantan;
        $ternak->domba_dewasa_betina   = $request->domba_dewasa_betina;

        $ternak->ayam_ras              = $request->ayam_ras;
        $ternak->ayam_buras            = $request->ayam_buras;
        $ternak->ayam_petelur          = $request->ayam_petelur;
        $ternak->itik                  = $request->itik;
        $ternak->puyuh                 = $request->puyuh;

        $ternak->keterangan            = $request->keterangan;

        $ternak->update($request->all());
        $ternak->save();

        return redirect('ternak');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ternak = Ternak::find($id);
        $ternak->delete();

        return redirect('ternak');
    }

    public function search(Request $request)
    {
        $user_type = Auth::user()->user_type;
        $now = session()->get('tahun_data');

        // retrieving searched data
        // $tahun = $request->tahun;
        $search = $request->search;
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        $ft_desa_kel = $request->desa_kel;

        if($user_type == "A"){
            $peternak = Peternak::all();
            if($peternak){
                $ternak = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nik', 'peternaks.nama', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $now);

                    if(isset($ft_kab_kota)){
                        $ternak->where('peternaks.kab_kota_id', $ft_kab_kota);
                    }
                    if(isset($ft_kecamatan)){
                        $ternak->where('peternaks.kecamatan_id', $ft_kecamatan);
                    }
                    if(isset($ft_desa_kel)){
                        $ternak->where('peternaks.desa_kel_id', $ft_desa_kel);
                    }
        
                    $kab_kota = Kabupaten_kota::all();
                    $kecamatan = Kecamatan::all();
                    $desa_kel = Desa_kelurahan::all();
            }else{
                echo "Tidak ada peternak";
            }
        }elseif($user_type == "B"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota)->get();
            $status_verifikasi = Verifikasi::where('daerah', $user_kab_kota)->where('tahun', $now)->where('data_type', 'B')->first();
            if($peternak){
                $ternak = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nik', 'peternaks.nama', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $now)
                    ->where('peternaks.kab_kota_id', $user_kab_kota);

                if(isset($ft_kecamatan)){
                    $ternak->where('peternaks.kecamatan_id', $ft_kecamatan);
                }
                if(isset($ft_desa_kel)){
                    $ternak->where('peternaks.desa_kel_id', $ft_desa_kel);
                }

                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
                $desa_kel = Desa_kelurahan::all();
            }else{
                echo "Tidak ada peternak";
            }
        }elseif($user_type == "C"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $user_kecamatan = Auth::user()->kecamatan_id;
            $peternak = Peternak::where('kecamatan_id', $user_kecamatan)->get();
            $status_verifikasi = Verifikasi::where('daerah', $user_kecamatan)->where('tahun', $now)->where('data_type', 'C')->first();
            if($peternak){
                $ternak = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nik', 'peternaks.nama', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $now)
                    ->where('peternaks.kab_kota_id', $user_kab_kota)
                    ->where('peternaks.kecamatan_id', $user_kecamatan);

                if(isset($ft_desa_kel)){
                    $ternak->where('peternaks.desa_kel_id', $ft_desa_kel);
                }

                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
                $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
            }else{
                echo "Tidak ada peternak";
            }
        }

        if(isset($search)){
            $ternak->where('peternaks.nama', 'like', "%".$search."%");
        }

        // if(isset($tahun)){
        //     $ternak->where('ternaks.tahun', $tahun);
        // }else{
        //     $ternak->where('ternaks.tahun', session()->get('tahun_data'));
        // }

        $result = $ternak->paginate(25);

        if($user_type == 'B' OR $user_type == 'C'){
            if($status_verifikasi == ''){
                $status_verifikasi = array(
                    'status_pengajuan' => 0,
                    'status_verifikasi' => 0,
                    'catatan' => ''
                );
            }
            return view('admin.ternak.ternak', ['status_verifikasi'=>$status_verifikasi, 'ternak'=>$result, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel]);
        }else{
            return view('admin.ternak.ternak', ['ternak'=>$result, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel]);
        }
        // return view('admin.ternak.ternak', ['ternak'=>$result,'desa_kel' => $desa_kel, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    public function export(Request $request)
    {
        ob_get_clean();
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data-Ternak.xls");
        
        $user_type = Auth::user()->user_type;

        // retrieving searched data
        // $tahun = $request->tahun;
        $now = session()->get('tahun_data');
        $search = $request->search;
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        $ft_desa_kel = $request->desa_kel;

        if($user_type == "A"){
            $peternak = Peternak::all();
            if($peternak){
                $ternak = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $now);
                // $total_ternak = TotalTernak::total_kolom_pr($tahun, $peternak);

                    if(isset($ft_kab_kota)){
                        $ternak->where('peternaks.kab_kota_id', $ft_kab_kota);
                    }
                    if(isset($ft_kecamatan)){
                        $ternak->where('peternaks.kecamatan_id', $ft_kecamatan);
                    }
                    if(isset($ft_desa_kel)){
                        $ternak->where('peternaks.desa_kel_id', $ft_desa_kel);
                    }
        
                    $kab_kota = Kabupaten_kota::all();
                    $kecamatan = Kecamatan::all();
                    $desa_kel = Desa_kelurahan::all();
            }else{
                echo "Tidak ada peternak";
            }
        }elseif($user_type == "B"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota)->get();
            if($peternak){
                $ternak = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $now)
                    ->where('peternaks.kab_kota_id', $user_kab_kota);
                // $total_ternak = TotalTernak::total_kolom_kk($tahun, $user_kab_kota, $peternak);

                if(isset($ft_kecamatan)){
                    $ternak->where('peternaks.kecamatan_id', $ft_kecamatan);
                }
                if(isset($ft_desa_kel)){
                    $ternak->where('peternaks.desa_kel_id', $ft_desa_kel);
                }

                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
                $desa_kel = Desa_kelurahan::all();
            }else{
                echo "Tidak ada peternak";
            }
        }elseif($user_type == "C"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $user_kecamatan = Auth::user()->kecamatan_id;
            $peternak = Peternak::where('kecamatan_id', $user_kecamatan)->get();
            if($peternak){
                $ternak = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $now)
                    ->where('peternaks.kab_kota_id', $user_kab_kota)
                    ->where('peternaks.kecamatan_id', $user_kecamatan);
                // $total_ternak = TotalTernak::total_kolom_kc($tahun, $user_kecamatan, $peternak);

                if(isset($ft_desa_kel)){
                    $ternak->where('peternaks.desa_kel_id', $ft_desa_kel);
                }

                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
                $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
            }else{
                echo "Tidak ada peternak";
            }
        }

        if(isset($search)){
            $ternak->where('peternaks.nama', 'like', "%".$search."%");
        }

        // if(isset($tahun)){
        //     $ternak->where('ternaks.tahun', $tahun);
        // }else{
        //     $tahun = session()->get('tahun_data');
        //     $ternak->where('ternaks.tahun', $tahun);
        // }

        $result = $ternak->get();

        if($user_type == "A"){
            $peternak = Peternak::all();
            $total_ternak = TotalTernak::total_kolom_pr($now, $peternak, $ft_kab_kota, $ft_kecamatan, $ft_desa_kel);
        }elseif($user_type == "B"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota)->get();
            $total_ternak = TotalTernak::total_kolom_kk($now, $user_kab_kota, $peternak, $ft_kecamatan, $ft_desa_kel);
        }elseif($user_type == "C"){
            $user_kecamatan = Auth::user()->kecamatan_id;
            $peternak = Peternak::where('kecamatan_id', $user_kecamatan)->get();
            $total_ternak = TotalTernak::total_kolom_kc($now, $user_kecamatan, $peternak, $ft_desa_kel);
        }

        echo '<center><h1>Data Ternak</h1></center>';
        echo '<center><h3>Tahun : '.$now.'</h3></center>';
        if($user_type == 'A'){
            echo 'Provinsi : Nusa Tenggara Barat<br>';    
        }elseif($user_type == 'B'){
            echo 'Provinsi : Nusa Tenggara Barat<br>';
            foreach($kab_kota as $kk){
                echo 'Kabupaten/Kota : '.$kk->nama_kab_kota.'<br>';
            }
        }elseif($user_type == 'C'){
            echo 'Provinsi : Nusa Tenggara Barat<br>';
            foreach($kab_kota as $kk){
                echo 'Kabupaten/Kota : '.$kk->nama_kab_kota.'<br>';
            }
            foreach($kecamatan as $kc){
                echo 'Kecamatan : '.$kc->nama_kecamatan.'<br>';
            }
        }

        echo '<table class="table table-hover text-nowrap" border="1">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align:middle;">No.</th>
                    <th rowspan="2" style="vertical-align:middle;">Peternak</th>
                    <th rowspan="2" style="vertical-align:middle;">NIK</th>
                    <th rowspan="2" style="vertical-align:middle;">Kabupaten/Kota</th>
                    <th rowspan="2" style="vertical-align:middle;">Kecamatan</th>
                    <th rowspan="2" style="vertical-align:middle; border-right:1px solid;">Desa/Kelurahan</th>
                    <th colspan="3" style="text-align:center">Sapi Jantan</th>
                    <th colspan="3" style="text-align:center; border-right:1px solid;">Sapi Betina</th>
                    <th colspan="3" style="text-align:center">Kerbau Jantan</th>
                    <th colspan="3" style="text-align:center; border-right:1px solid;">Kerbau Betina</th>
                    <th colspan="3" style="text-align:center">Kuda Jantan</th>
                    <th colspan="3" style="text-align:center; border-right:1px solid;">Kuda Betina</th>
                    <th colspan="3" style="text-align:center">Kambing Jantan</th>
                    <th colspan="3" style="text-align:center; border-right:1px solid;">Kambing Betina</th>
                    <th colspan="3" style="text-align:center">Babi Jantan</th>
                    <th colspan="3" style="text-align:center; border-right:1px solid;">Babi Betina</th>
                    <th colspan="3" style="text-align:center">Domba Jantan</th>
                    <th colspan="3" style="text-align:center; border-right:1px solid;">Domba Betina</th>
                    <th rowspan="2" style="vertical-align:middle;">Ayam Ras</th>
                    <th rowspan="2" style="vertical-align:middle;">Ayam Buras</th>
                    <th rowspan="2" style="vertical-align:middle;">Ayam Layer</th>
                    <th rowspan="2" style="vertical-align:middle;">Itik</th>
                    <th rowspan="2" style="vertical-align:middle;">Puyuh</th>
                    <th rowspan="2" style="vertical-align:middle;">Keterangan</th>
                </tr>
                <tr>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                    <th>Anak</th>
                    <th>Muda</th>
                    <th style="border-right:1px solid;">Dewasa</th>
                </tr>
                </thead>
            <tbody>';
                $no=1;
                foreach($result as $t){
                    if($t == ''){
                        echo '<tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                            <td>20</td>
                        </tr>';
                    }else{
                        echo '<tr>
                            <td>'.$no++.'</td>
                            <td>'.$t->nama."</td>
                            <td>'".$t->nik.'</td>
                            <td style="border-right:1px solid;">';
                                foreach($kab_kota as $kk1){
                                    if($t->kab_kota_id == $kk1->id){
                                        echo $kk1->nama_kab_kota;
                                    }
                                }
                            echo '</td>';
                            echo '<td style="border-right:1px solid;">';
                                foreach($kecamatan as $kc1){
                                    if($t->kecamatan_id == $kc1->id){
                                        echo $kc1->nama_kecamatan;
                                    }
                                }
                            echo '</td>';
                            echo '<td style="border-right:1px solid;">';
                                foreach($desa_kel as $dk){
                                    if($t->desa_kel_id == $dk->id){
                                        echo $dk->nama_desa_kel;
                                    }
                                }
                            echo '</td>';
                            echo '<td style="text-align:center">'.($t->sapi_anak_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->sapi_muda_jantan + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->sapi_dewasa_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->sapi_anak_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->sapi_muda_betina + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->sapi_dewasa_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kerbau_anak_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kerbau_muda_jantan + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->kerbau_dewasa_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kerbau_anak_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kerbau_muda_betina + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->kerbau_dewasa_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kuda_anak_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kuda_muda_jantan + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->kuda_dewasa_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kuda_anak_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kuda_muda_betina + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->kuda_dewasa_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kambing_anak_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kambing_muda_jantan + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->kambing_dewasa_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kambing_anak_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->kambing_muda_betina + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->kambing_dewasa_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->babi_anak_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->babi_muda_jantan + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->babi_dewasa_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->babi_anak_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->babi_muda_betina + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->babi_dewasa_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->domba_anak_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->domba_muda_jantan + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->domba_dewasa_jantan + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->domba_anak_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->domba_muda_betina + 0).'</td>';
                            echo '<td style="text-align:center; border-right:1px solid;">'.($t->domba_dewasa_betina + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->ayam_ras + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->ayam_buras + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->ayam_petelur + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->itik + 0).'</td>';
                            echo '<td style="text-align:center">'.($t->puyuh + 0).'</td>';
                            echo '<td>'.$t->keterangan.'</td>';
                        echo '</tr>';
                    }
                }
                echo '<tr>';
                    echo '<td colspan="6" style="font-weight:bold;">Total Keseluruhan Ternak</td>';
                    echo '<td colspan="41" style="text-align:center; font-weight:bold; ">'.array_sum($total_ternak).' Ekor</td>';
                echo '</tr>';
            echo '</tbody>';
        echo '</table>';
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'mimes:xls,xlsx'
        ]);

        Excel::import(new TernaksImport(), $request->file('file'));
        return redirect('ternak');
    }
}


