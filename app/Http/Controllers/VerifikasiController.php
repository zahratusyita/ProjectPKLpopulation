<?php

namespace App\Http\Controllers;

use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Ternak;
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
        if (session()->get('tahun_data') != '') {
            $user_type = Auth::user()->user_type;
            $tahun_data = session()->get('tahun_data');

            if ($user_type == 'A') {
                $kab_kota = Kabupaten_kota::all();
                $kecamatan = Kecamatan::all();

                // Admin Provinsi: tampilkan pengajuan regional dari Kabupaten (tabel verifikasis)
                $verifikasi = DB::table('verifikasis')
                    ->join('kabupaten_kotas', 'verifikasis.daerah', '=', 'kabupaten_kotas.id')
                    ->select('verifikasis.*', 'kabupaten_kotas.id as kab_kota_id', 'kabupaten_kotas.nama_kab_kota')
                    ->where('verifikasis.data_type', 'B')
                    ->where('verifikasis.tahun', $tahun_data)
                    ->where('verifikasis.status_pengajuan', true)
                    ->paginate(25);

                return view('admin.verifikasi.verifikasi', [
                    'verifikasi' => $verifikasi,
                    'kab_kota' => $kab_kota,
                    'kecamatan' => $kecamatan,
                ]);
            } elseif ($user_type == 'B') {
                $user_kab_kota = Auth::user()->kab_kota_id;
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
                $desa_kel = Desa_kelurahan::all();

                // Admin Kabupaten: tampilkan seluruh status sebagai riwayat verifikasi tahun aktif.
                $ternak_pending = DB::table('peternaks')
                    ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                    ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                    ->where('ternaks.tahun', $tahun_data)
                    ->where('peternaks.kab_kota_id', $user_kab_kota);
                $pending_count = (clone $ternak_pending)->where('ternaks.status_pengajuan', 1)->count();
                $ternak_pending = $ternak_pending->orderByDesc('ternaks.updated_at')->paginate(25);

                return view('admin.verifikasi.verifikasi', [
                    'ternak_pending' => $ternak_pending,
                    'kab_kota' => $kab_kota,
                    'kecamatan' => $kecamatan,
                    'desa_kel' => $desa_kel,
                    'pending_count' => $pending_count,
                ]);
            }
        } else {
            return view('admin.tahun_data');
        }
    }

    /**
     * Store a newly created resource in storage (Admin B ajukan ke Provinsi)
     */
    public function store(Request $request)
    {
        $user_type = Auth::user()->user_type;
        abort_unless($user_type === 'B', 403);

        $daerah_asal = Auth::user()->kab_kota_id;
        $tahunData = session()->get('tahun_data');
        $dataTernak = DB::table('ternaks')
            ->join('peternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
            ->where('peternaks.kab_kota_id', $daerah_asal)
            ->where('ternaks.tahun', $tahunData);

        if (! (clone $dataTernak)->exists()) {
            return redirect('ternak')->withErrors(['verifikasi' => 'Tidak ada data ternak pada tahun aktif untuk diajukan.']);
        }

        if ((clone $dataTernak)->where('ternaks.status_pengajuan', '!=', 2)->exists()) {
            return redirect('ternak')->withErrors(['verifikasi' => 'Semua data Kecamatan harus diverifikasi terlebih dahulu sebelum diajukan ke Provinsi.']);
        }

        Verifikasi::updateOrCreate(
                [
                    'data_type' => $user_type,
                    'tahun' => $tahunData,
                    'daerah' => $daerah_asal,
                ],
                [
                    'status_pengajuan' => true,
                    'tanggal_pengajuan' => now(),
                    'status_verifikasi' => false,
                    'tanggal_verifikasi' => now(),
                    'catatan' => null,
                ]
            );

        return redirect('ternak');
    }

    /**
     * Update the specified resource in storage (Admin A verifikasi/tolak pengajuan Admin B)
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->user_type == 'A') {
            $request->validate([
                'verifikasi' => 'required|in:1,2',
                'catatan' => 'required_if:verifikasi,2|nullable|string',
            ]);
            $verifikasi = Verifikasi::findOrFail($id);

            abort_unless($verifikasi->data_type === 'B' && (string) $verifikasi->tahun === (string) session()->get('tahun_data'), 403);

            DB::transaction(function () use ($verifikasi, $request) {
                $verifikasi->status_verifikasi = (int) $request->verifikasi;
                $verifikasi->status_pengajuan = (int) $request->verifikasi === 1;
                $verifikasi->tanggal_verifikasi = now();
                $verifikasi->catatan = $request->catatan;
                $verifikasi->save();

                if ((int) $request->verifikasi === 2) {
                    DB::table('ternaks')
                        ->join('peternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                        ->where('peternaks.kab_kota_id', $verifikasi->daerah)
                        ->where('ternaks.tahun', $verifikasi->tahun)
                        ->where('ternaks.status_pengajuan', 2)
                        ->update(['ternaks.status_pengajuan' => 3]);
                }
            });

            return redirect('verifikasi');
        }
    }

    /**
     * Batalkan pengajuan regional (Admin B batalkan pengajuan ke Provinsi)
     */
    public function cancel(string $id)
    {
        if (Auth::user()->user_type !== 'B') {
            abort(403);
        }

        $verifikasi = Verifikasi::findOrFail($id);
        $userType = Auth::user()->user_type;
        $daerah = Auth::user()->kab_kota_id;

        if (
            $verifikasi->data_type !== $userType ||
            (int) $verifikasi->daerah !== (int) $daerah ||
            (string) $verifikasi->tahun !== (string) session()->get('tahun_data') ||
            !$verifikasi->status_pengajuan ||
            (int) $verifikasi->status_verifikasi !== 0
        ) {
            abort(403);
        }

        $verifikasi->delete();

        return back()->with('success', 'Pengajuan data dibatalkan. Anda dapat melanjutkan perubahan data.');
    }

    /**
     * Verifikasi SATU data ternak (Admin B).
     */
    public function verifySingle(Request $request, string $id)
    {
        $user_type = Auth::user()->user_type;
        if ($user_type !== 'B')
            abort(403);

        $ternak = Ternak::findOrFail($id);
        $peternak = DB::table('peternaks')->where('id', $ternak->peternak_id)->first();
        if (!$peternak || $peternak->kab_kota_id != Auth::user()->kab_kota_id) {
            abort(403);
        }
        abort_unless((string) $ternak->tahun === (string) session()->get('tahun_data'), 403);

        if ((int) $ternak->status_pengajuan === 1) {
            $request->validate(['catatan' => 'nullable|string']);
            $ternak->status_pengajuan = 2;
            if ($request->filled('catatan')) {
                $ternak->keterangan = $request->catatan;
            }
            $ternak->save();
            Verifikasi::invalidateProvincialApproval(
                (int) $peternak->kab_kota_id,
                (int) $ternak->tahun
            );
        }

        return redirect('verifikasi')->with('success', 'Data berhasil diverifikasi.');
    }

    /**
     * Verifikasi SEMUA data ternak pending sekaligus (Admin B).
     */
    public function verifyAll()
    {
        $user_type = Auth::user()->user_type;
        $tahun_data = session()->get('tahun_data');

        if ($user_type == 'B') {
            $updated = DB::table('ternaks')
                ->join('peternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                ->where('peternaks.kab_kota_id', Auth::user()->kab_kota_id)
                ->where('ternaks.tahun', $tahun_data)
                ->where('ternaks.status_pengajuan', 1)
                ->update([
                    'ternaks.status_pengajuan' => 2,
                    'ternaks.updated_at' => now(),
                ]);

            if ($updated > 0) {
                Verifikasi::invalidateProvincialApproval(
                    (int) Auth::user()->kab_kota_id,
                    (int) $tahun_data
                );
            }
        }

        return redirect('verifikasi')->with('success', 'Semua data berhasil diverifikasi.');
    }

    /**
     * Tolak/revisi SATU data ternak dengan catatan (Admin B).
     */
    public function rejectSingle(Request $request, string $id)
    {
        $user_type = Auth::user()->user_type;
        if ($user_type !== 'B')
            abort(403);

        $request->validate(['catatan' => 'required|string']);
        $ternak = Ternak::findOrFail($id);
        $peternak = DB::table('peternaks')->where('id', $ternak->peternak_id)->first();
        if (!$peternak || $peternak->kab_kota_id != Auth::user()->kab_kota_id) {
            abort(403);
        }
        abort_unless((string) $ternak->tahun === (string) session()->get('tahun_data'), 403);

        if ((int) $ternak->status_pengajuan === 1) {
            $ternak->status_pengajuan = 3; // Revisi
            $ternak->keterangan = $request->catatan ?? $ternak->keterangan;
            $ternak->save();
        }

        return redirect('verifikasi')->with('success', 'Data ditolak/direvisi.');
    }

    /**
     * Search verifikasi data.
     */
    public function search(Request $request)
    {
        $user_type = Auth::user()->user_type;
        $tahun_data = session()->get('tahun_data');
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        $ft_desa_kel = $request->desa_kel;
        $search = $request->search;

        if ($user_type == 'A') {
            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();

            $verifikasi = DB::table('verifikasis')
                ->join('kabupaten_kotas', 'verifikasis.daerah', '=', 'kabupaten_kotas.id')
                ->select('verifikasis.*', 'kabupaten_kotas.id as kab_kota_id', 'kabupaten_kotas.nama_kab_kota')
                ->where('verifikasis.data_type', 'B')
                ->where('verifikasis.tahun', $tahun_data)
                ->where('verifikasis.status_pengajuan', true);

            if (isset($ft_kab_kota) && $ft_kab_kota != '') {
                $verifikasi->where('verifikasis.daerah', $ft_kab_kota);
            }

            $result = $verifikasi->paginate(25);

            return view('admin.verifikasi.verifikasi', [
                'verifikasi' => $result,
                'kab_kota' => $kab_kota,
                'kecamatan' => $kecamatan,
            ]);

        } elseif ($user_type == 'B') {
            $user_kab_kota = Auth::user()->kab_kota_id;
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            $desa_kel = Desa_kelurahan::all();

            $ternak_pending = DB::table('peternaks')
                ->join('ternaks', 'peternaks.id', '=', 'ternaks.peternak_id')
                ->select('peternaks.id', 'peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'ternaks.*')
                ->where('ternaks.tahun', $tahun_data)
                ->where('peternaks.kab_kota_id', $user_kab_kota);

            if (isset($ft_kecamatan) && $ft_kecamatan != '') {
                $ternak_pending->where('peternaks.kecamatan_id', $ft_kecamatan);
            }
            if (isset($ft_desa_kel) && $ft_desa_kel != '') {
                $ternak_pending->where('peternaks.desa_kel_id', $ft_desa_kel);
            }
            if (isset($search) && $search != '') {
                $ternak_pending->where('peternaks.nama', 'like', "%" . $search . "%");
            }

            $pending_count = (clone $ternak_pending)->where('ternaks.status_pengajuan', 1)->count();
            $result = $ternak_pending->orderByDesc('ternaks.updated_at')->paginate(25);

            return view('admin.verifikasi.verifikasi', [
                'ternak_pending' => $result,
                'kab_kota' => $kab_kota,
                'kecamatan' => $kecamatan,
                'desa_kel' => $desa_kel,
                'pending_count' => $pending_count,
            ]);
        }
    }
}
