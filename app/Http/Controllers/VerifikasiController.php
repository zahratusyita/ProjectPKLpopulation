<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(session()->get('tahun_data') != ''){
            $user_type = Auth::user()->user_type;
            $tahun_data = session()->get('tahun_data');

            if($user_type == 'A'){
                $kab_kota = Kabupaten_kota::all();
                $kecamatan = Kecamatan::all();
                $verifikasi = DB::table('verifikasis')
                    ->join('kabupaten_kotas', 'verifikasis.daerah', '=', 'kabupaten_kotas.id')
                    ->select('verifikasis.*', 'kabupaten_kotas.id as kab_kota_id', 'kabupaten_kotas.nama_kab_kota')
                    ->where('verifikasis.data_type', 'B')
                    ->where('verifikasis.tahun', $tahun_data)
                    ->paginate(25);
            }elseif($user_type == 'B'){
                $user_kab_kota = Auth::user()->kab_kota_id;
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
                // $verifikasi = Verifikasi::where('daerah', Auth::user()->kab_kota_id)->paginate(25);
                $verifikasi = DB::table('verifikasis')
                    ->join('kecamatans', 'verifikasis.daerah', '=', 'kecamatans.id')
                    ->select('verifikasis.*', 'kecamatans.id as kec_id', 'kecamatans.kab_kota_id', 'kecamatans.nama_kecamatan')
                    ->where('verifikasis.data_type', 'C')
                    ->where('verifikasis.tahun', $tahun_data)
                    ->where('kecamatans.kab_kota_id', Auth::user()->kab_kota_id)
                    ->paginate(25);
            }

            return view('admin.verifikasi.verifikasi', ['verifikasi' => $verifikasi, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
        }else{
            return view('admin.tahun_data');
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
        $user_type = Auth::user()->user_type;
        if($user_type == 'B'){
            $daerah_asal = Auth::user()->kab_kota_id;
        }
        if($user_type == 'C'){
            $daerah_asal = Auth::user()->kecamatan_id;
        }

        if($user_type == 'B' OR $user_type == 'C'){
            Verifikasi::create([
                'data_type'             => $user_type,
                'tahun'                 => session()->get('tahun_data'),
                'daerah'                => $daerah_asal,
                'status_pengajuan'      => true,
                'tanggal_pengajuan'     => now(),
                'status_verifikasi'     => null,
                'tanggal_verifikasi'    => now(),
                'catatan'               => null
            ]);
        }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->user_type == 'A' OR Auth::user()->user_type == 'B'){
            $verifikasi = Verifikasi::findOrFail($id);

            $verifikasi->status_verifikasi  = $request->verifikasi;
            $verifikasi->tanggal_verifikasi = now();
            $verifikasi->catatan            = $request->catatan;

            $verifikasi->update();
            $verifikasi->save();

            return redirect('verifikasi');
        }elseif(Auth::user()->user_type == 'C'){
            $verifikasi = Verifikasi::findOrFail($id);
            $verifikasi->status_verifikasi = null;

            $verifikasi->update();
            $verifikasi->save();

            return redirect('ternak');
        }
    }

    public function cancel(string $id)
    {
        if (Auth::user()->user_type !== 'C' && Auth::user()->user_type !== 'B') {
            abort(403);
        }

        $verifikasi = Verifikasi::findOrFail($id);
        $userType = Auth::user()->user_type;
        $daerah = $userType === 'B' ? Auth::user()->kab_kota_id : Auth::user()->kecamatan_id;

        if (
            $verifikasi->data_type !== $userType ||
            (int) $verifikasi->daerah !== (int) $daerah ||
            (string) $verifikasi->tahun !== (string) session()->get('tahun_data') ||
            ! $verifikasi->status_pengajuan ||
            $verifikasi->status_verifikasi !== null
        ) {
            abort(403);
        }

        $verifikasi->delete();

        return back()->with('success', 'Pengajuan data dibatalkan. Anda dapat melanjutkan perubahan data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $user_type = Auth::user()->user_type;
        $tahun_data = session()->get('tahun_data');
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;

        if($user_type == 'A'){
            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();
            $verifikasi = DB::table('verifikasis')
                ->join('kabupaten_kotas', 'verifikasis.daerah', '=', 'kabupaten_kotas.id')
                ->select('verifikasis.*', 'kabupaten_kotas.id as kab_kota_id', 'kabupaten_kotas.nama_kab_kota')
                ->where('verifikasis.data_type', 'B')
                ->where('verifikasis.tahun', $tahun_data);

            if(isset($ft_kab_kota)){
                $verifikasi->where('verifikasis.daerah', 'like', substr($ft_kecamatan, 0, -2).'%');
            }
            if(isset($ft_kecamatan)){
                $verifikasi->where('verifikasis.daerah', $ft_kecamatan);
            }
        }elseif($user_type == 'B'){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            // $verifikasi = Verifikasi::where('daerah', Auth::user()->kab_kota_id)->paginate(25);
            $verifikasi = DB::table('verifikasis')
                ->join('kecamatans', 'verifikasis.daerah', '=', 'kecamatans.id')
                ->select('verifikasis.*', 'kecamatans.id as kec_id', 'kecamatans.kab_kota_id', 'kecamatans.nama_kecamatan')
                ->where('verifikasis.data_type', 'C')
                ->where('verifikasis.tahun', $tahun_data)
                ->where('kecamatans.kab_kota_id', Auth::user()->kab_kota_id);
            
            if(isset($ft_kecamatan)){
                $verifikasi->where('verifikasis.daerah', $ft_kecamatan);
            }
        }

        $result = $verifikasi->paginate(25);

        return view('admin.verifikasi.verifikasi', ['verifikasi' => $result, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }
}
