<?php

namespace App\Http\Controllers;

use App\Models\MutasiTernak;
use App\Models\Peternak;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Desa_kelurahan;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MutasiTernakController extends Controller
{
    public function index($jenis)
    {
        if(session()->get('tahun_data') != ''){
            $now = session()->get('tahun_data');
            $user_type = Auth::user()->user_type;

            $query = DB::table('peternaks')
                ->join('mutasi_ternaks', 'peternaks.id', '=', 'mutasi_ternaks.peternak_id')
                ->select('peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'mutasi_ternaks.*')
                ->where('mutasi_ternaks.jenis_mutasi', $jenis);
            
            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();
            $desa_kel = Desa_kelurahan::all();

            if($user_type == "A"){
                // Can see all
            }elseif($user_type == "B"){
                $user_kab_kota = Auth::user()->kab_kota_id;
                $query->where('peternaks.kab_kota_id', $user_kab_kota);
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
                $status_verifikasi = Verifikasi::where('daerah', $user_kab_kota)->where('tahun', $now)->first();
            }elseif($user_type == "C"){
                $user_kab_kota = Auth::user()->kab_kota_id;
                $user_kecamatan = Auth::user()->kecamatan_id;
                $query->where('peternaks.kab_kota_id', $user_kab_kota)
                      ->where('peternaks.kecamatan_id', $user_kecamatan);
                
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
                $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
                $status_verifikasi = Verifikasi::where('daerah', $user_kecamatan)->where('tahun', $now)->first();
            }

            $mutasi = $query->orderBy('mutasi_ternaks.tanggal', 'desc')->paginate(25);

            if($user_type == 'B' OR $user_type == 'C'){
                if($status_verifikasi == ''){
                    $status_verifikasi = array(
                        'status_pengajuan' => 0,
                        'status_verifikasi' => 0,
                        'catatan' => ''
                    );
                }
                return view('admin.mutasi.index', [
                    'mutasi' => $mutasi, 
                    'jenis'=> $jenis,
                    'kab_kota' => $kab_kota, 
                    'kecamatan' => $kecamatan, 
                    'desa_kel' => $desa_kel,
                    'status_verifikasi' => $status_verifikasi
                ]);
            }else{
                return view('admin.mutasi.index', [
                    'mutasi' => $mutasi, 
                    'jenis'=> $jenis,
                    'kab_kota' => $kab_kota, 
                    'kecamatan' => $kecamatan, 
                    'desa_kel' => $desa_kel
                ]);
            }
        }else{
            return view('admin.tahun_data');
        }
    }

    public function create($jenis)
    {
        $user_type = Auth::user()->user_type;
        $peternakQuery = Peternak::select('id', 'nik', 'nama');

        if($user_type == "B"){
            $peternakQuery->where('kab_kota_id', Auth::user()->kab_kota_id);
        }elseif($user_type == "C"){
            $peternakQuery->where('kecamatan_id', Auth::user()->kecamatan_id);
        }
        $peternak = $peternakQuery->get();

        return view('admin.mutasi.form', ['peternak' => $peternak, 'jenis' => $jenis]);
    }

    public function store(Request $request, $jenis)
    {
        $request->validate([
            'tanggal'               => 'required|date',
            'peternak_id'           => 'required|numeric',
            'sapi_anak_jantan'      => 'numeric|nullable',
            // we skip explicit rules for all 40 columns for brevity as it defaults nicely 
            // but ensuring typical data rules
        ]);

        $data = $request->except('_token', 'peternak');
        // Handle mapping if 'peternak' select box uses different name
        if($request->has('peternak')) {
            $data['peternak_id'] = $request->peternak;
        }

        // replace null with 0 for animal columns to avoid database error
        $animal_columns = ['sapi_anak_jantan', 'sapi_anak_betina', 'sapi_muda_jantan', 'sapi_muda_betina', 'sapi_dewasa_jantan', 'sapi_dewasa_betina', 'kerbau_anak_jantan', 'kerbau_anak_betina', 'kerbau_muda_jantan', 'kerbau_muda_betina', 'kerbau_dewasa_jantan', 'kerbau_dewasa_betina', 'kuda_anak_jantan', 'kuda_anak_betina', 'kuda_muda_jantan', 'kuda_muda_betina', 'kuda_dewasa_jantan', 'kuda_dewasa_betina', 'kambing_anak_jantan', 'kambing_anak_betina', 'kambing_muda_jantan', 'kambing_muda_betina', 'kambing_dewasa_jantan', 'kambing_dewasa_betina', 'babi_anak_jantan', 'babi_anak_betina', 'babi_muda_jantan', 'babi_muda_betina', 'babi_dewasa_jantan', 'babi_dewasa_betina', 'domba_anak_jantan', 'domba_anak_betina', 'domba_muda_jantan', 'domba_muda_betina', 'domba_dewasa_jantan', 'domba_dewasa_betina', 'ayam_ras', 'ayam_buras', 'ayam_petelur', 'itik', 'puyuh'];

        foreach($animal_columns as $col) {
            $data[$col] = $request->input($col, 0) ?: 0;
        }

        $data['jenis_mutasi'] = $jenis;
        $data['tahun'] = date('Y', strtotime($request->tanggal));
        
        MutasiTernak::create($data);

        return redirect('mutasi/'.$jenis);
    }

    public function edit($jenis, $id)
    {
        $user_type = Auth::user()->user_type;
        $peternakQuery = Peternak::select('id', 'nik', 'nama');

        if($user_type == "B"){
            $peternakQuery->where('kab_kota_id', Auth::user()->kab_kota_id);
        }elseif($user_type == "C"){
            $peternakQuery->where('kecamatan_id', Auth::user()->kecamatan_id);
        }
        $peternak = $peternakQuery->get();

        $mutasi = MutasiTernak::findOrFail($id);

        return view('admin.mutasi.edit', ['mutasi' => $mutasi, 'peternak' => $peternak, 'jenis' => $jenis]);
    }

    public function update(Request $request, $jenis, $id)
    {
        $mutasi = MutasiTernak::findOrFail($id);

        $data = $request->except('_token', 'peternak');
        if($request->has('peternak')) {
            $data['peternak_id'] = $request->peternak;
        }

        $animal_columns = ['sapi_anak_jantan', 'sapi_anak_betina', 'sapi_muda_jantan', 'sapi_muda_betina', 'sapi_dewasa_jantan', 'sapi_dewasa_betina', 'kerbau_anak_jantan', 'kerbau_anak_betina', 'kerbau_muda_jantan', 'kerbau_muda_betina', 'kerbau_dewasa_jantan', 'kerbau_dewasa_betina', 'kuda_anak_jantan', 'kuda_anak_betina', 'kuda_muda_jantan', 'kuda_muda_betina', 'kuda_dewasa_jantan', 'kuda_dewasa_betina', 'kambing_anak_jantan', 'kambing_anak_betina', 'kambing_muda_jantan', 'kambing_muda_betina', 'kambing_dewasa_jantan', 'kambing_dewasa_betina', 'babi_anak_jantan', 'babi_anak_betina', 'babi_muda_jantan', 'babi_muda_betina', 'babi_dewasa_jantan', 'babi_dewasa_betina', 'domba_anak_jantan', 'domba_anak_betina', 'domba_muda_jantan', 'domba_muda_betina', 'domba_dewasa_jantan', 'domba_dewasa_betina', 'ayam_ras', 'ayam_buras', 'ayam_petelur', 'itik', 'puyuh'];

        foreach($animal_columns as $col) {
            $data[$col] = $request->input($col, 0) ?: 0;
        }
        
        $data['tahun'] = date('Y', strtotime($request->tanggal));
        $mutasi->update($data);

        return redirect('mutasi/'.$jenis);
    }

    public function destroy($jenis, $id)
    {
        $mutasi = MutasiTernak::findOrFail($id);
        $mutasi->delete();

        return redirect('mutasi/'.$jenis);
    }
}
