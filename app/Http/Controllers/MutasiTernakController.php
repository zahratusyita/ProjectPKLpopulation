<?php

namespace App\Http\Controllers;

use App\Exports\MutasiExport;
use App\Exports\MutasiTemplateExport;
use App\Imports\MutasiTernaksImport;
use App\Models\MutasiTernak;
use App\Models\Peternak;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Desa_kelurahan;
use App\Services\TernakMutationService;
use App\Support\MutasiSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class MutasiTernakController extends Controller
{
    public function __construct(
        private readonly TernakMutationService $ternakMutationService
    ) {
    }

    public function index($jenis)
    {
        if(session()->get('tahun_data') != ''){
            $now = session()->get('tahun_data');
            $user_type = Auth::user()->user_type;

            $query = DB::table('peternaks')
                ->join('mutasi_ternaks', 'peternaks.id', '=', 'mutasi_ternaks.peternak_id')
                ->select('peternaks.nama', 'peternaks.nik', 'peternaks.kab_kota_id', 'peternaks.kecamatan_id', 'peternaks.desa_kel_id', 'mutasi_ternaks.*')
                ->where('mutasi_ternaks.jenis_mutasi', $jenis)
                ->where('mutasi_ternaks.tahun', $now);
            
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
            }elseif($user_type == "C"){
                $user_kab_kota = Auth::user()->kab_kota_id;
                $user_kecamatan = Auth::user()->kecamatan_id;
                $query->where('peternaks.kab_kota_id', $user_kab_kota)
                      ->where('peternaks.kecamatan_id', $user_kecamatan);
                
                $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
                $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
                $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
            }

            if (request('kab_kota')) {
                $query->where('peternaks.kab_kota_id', request('kab_kota'));
            }

            if (request('kecamatan')) {
                $query->where('peternaks.kecamatan_id', request('kecamatan'));
            }

            if (request('desa_kel')) {
                $query->where('peternaks.desa_kel_id', request('desa_kel'));
            }

            if (request('search')) {
                $query->where(function ($builder) {
                    $builder->where('peternaks.nama', 'like', '%'.request('search').'%')
                        ->orWhere('peternaks.nik', 'like', '%'.request('search').'%');
                });
            }

            $mutasi = $query->orderBy('mutasi_ternaks.tanggal', 'desc')->paginate(25);

            return view('admin.mutasi.index', [
                'mutasi' => $mutasi,
                'jenis'=> $jenis,
                'kab_kota' => $kab_kota,
                'kecamatan' => $kecamatan,
                'desa_kel' => $desa_kel,
            ]);
        }else{
            return view('admin.tahun_data');
        }
    }

    public function create($jenis)
    {
        $this->ensureCanManageMutasi();
        $peternak = $this->peternakQueryByUser()->get();

        return view('admin.mutasi.form', [
            'peternak' => $peternak,
            'jenis' => $jenis,
            'mamalia' => MutasiSchema::mamalia(),
            'unggas' => MutasiSchema::unggas(),
        ]);
    }

    public function store(Request $request, $jenis)
    {
        $this->ensureCanManageMutasi();
        $data = $this->validatedMutasiData($request, $jenis);

        $this->ternakMutationService->create($data);

        return redirect('mutasi/'.$jenis)->with('success', 'Data mutasi berhasil ditambahkan.');
    }

    public function edit($jenis, $id)
    {
        $this->ensureCanManageMutasi();
        $peternak = $this->peternakQueryByUser()->get();

        $mutasi = MutasiTernak::findOrFail($id);

        return view('admin.mutasi.edit', [
            'mutasi' => $mutasi,
            'peternak' => $peternak,
            'jenis' => $jenis,
            'mamalia' => MutasiSchema::mamalia(),
            'unggas' => MutasiSchema::unggas(),
        ]);
    }

    public function update(Request $request, $jenis, $id)
    {
        $this->ensureCanManageMutasi();
        $mutasi = MutasiTernak::findOrFail($id);
        $data = $this->validatedMutasiData($request, $jenis);
        $this->ternakMutationService->update($mutasi, $data);

        return redirect('mutasi/'.$jenis)->with('success', 'Data mutasi berhasil diperbarui.');
    }

    public function destroy($jenis, $id)
    {
        $this->ensureCanManageMutasi();
        $mutasi = MutasiTernak::findOrFail($id);
        $this->ternakMutationService->delete($mutasi);

        return redirect('mutasi/'.$jenis)->with('success', 'Data mutasi berhasil dihapus.');
    }

    public function export(Request $request, $jenis)
    {
        if(session()->get('tahun_data') == ''){
            return redirect()->route('tahun-data');
        }

        $query = $this->mutasiQuery($jenis);
        $rows = $query->orderBy('mutasi_ternaks.tanggal', 'desc')->get();
        $filename = 'Data-Mutasi-'.ucfirst($jenis).'-'.session()->get('tahun_data').'.xlsx';

        return Excel::download(new MutasiExport($rows, $jenis, (string) session()->get('tahun_data')), $filename);
    }

    public function template($jenis)
    {
        if(session()->get('tahun_data') == ''){
            return redirect()->route('tahun-data');
        }

        $filename = 'Template-Import-Mutasi-'.ucfirst($jenis).'.xlsx';

        return Excel::download(new MutasiTemplateExport($jenis), $filename);
    }

    public function import(Request $request, $jenis)
    {
        $this->ensureCanManageMutasi();

        if(session()->get('tahun_data') == ''){
            return redirect()->route('tahun-data');
        }

        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(
                new MutasiTernaksImport(
                    $jenis,
                    $this->peternakQueryByUser()->get(['id', 'nik', 'nama']),
                    (int) session()->get('tahun_data')
                ),
                $request->file('file')
            );

            return redirect('mutasi/'.$jenis)->with('success', 'Import data mutasi berhasil.');
        } catch (\Throwable $e) {
            return redirect('mutasi/'.$jenis)->withErrors([
                'file' => $e->getMessage(),
            ]);
        }
    }

    private function validatedMutasiData(Request $request, string $jenis): array
    {
        $peternakIds = $this->peternakQueryByUser()->pluck('id')->all();

        $rules = [
            'tanggal' => 'required|date',
            'peternak' => ['required', 'numeric', Rule::in($peternakIds)],
            'keterangan' => 'nullable|string',
        ];

        if (MutasiSchema::isKelahiran($jenis)) {
            foreach (array_keys(MutasiSchema::mamalia()) as $field) {
                $rules[$field.'_jantan'] = 'nullable|integer|min:0';
                $rules[$field.'_betina'] = 'nullable|integer|min:0';
            }

            foreach (array_keys(MutasiSchema::unggas()) as $field) {
                $rules[$field] = 'nullable|integer|min:0';
            }
        } else {
            foreach (MutasiSchema::animalColumns() as $field) {
                $rules[$field] = 'nullable|integer|min:0';
            }
        }

        $validated = $request->validate($rules);

        $data = [
            'tanggal' => $validated['tanggal'],
            'tahun' => date('Y', strtotime($validated['tanggal'])),
            'jenis_mutasi' => $jenis,
            'peternak_id' => $validated['peternak'],
            'keterangan' => $validated['keterangan'] ?? null,
        ];

        $animalData = MutasiSchema::fillAnimalData($jenis, $validated);

        if (MutasiSchema::totalAnimalCount($animalData) === 0) {
            throw ValidationException::withMessages([
                'hewan' => 'Minimal isi satu jumlah ternak.',
            ]);
        }

        return array_merge($data, $animalData);
    }

    private function mutasiQuery(string $jenis)
    {
        $now = session()->get('tahun_data');
        $user_type = Auth::user()->user_type;

        $query = DB::table('peternaks')
            ->join('mutasi_ternaks', 'peternaks.id', '=', 'mutasi_ternaks.peternak_id')
            ->leftJoin('kabupaten_kotas', 'peternaks.kab_kota_id', '=', 'kabupaten_kotas.id')
            ->leftJoin('kecamatans', 'peternaks.kecamatan_id', '=', 'kecamatans.id')
            ->leftJoin('desa_kelurahans', 'peternaks.desa_kel_id', '=', 'desa_kelurahans.id')
            ->select(
                'peternaks.nama',
                'peternaks.nik',
                'peternaks.kab_kota_id',
                'peternaks.kecamatan_id',
                'peternaks.desa_kel_id',
                'kabupaten_kotas.nama_kab_kota',
                'kecamatans.nama_kecamatan',
                'desa_kelurahans.nama_desa_kel',
                'mutasi_ternaks.*'
            )
            ->where('mutasi_ternaks.jenis_mutasi', $jenis)
            ->where('mutasi_ternaks.tahun', $now);

        if($user_type == "B"){
            $query->where('peternaks.kab_kota_id', Auth::user()->kab_kota_id);
        }elseif($user_type == "C"){
            $query->where('peternaks.kab_kota_id', Auth::user()->kab_kota_id)
                ->where('peternaks.kecamatan_id', Auth::user()->kecamatan_id);
        }

        if (request('kab_kota')) {
            $query->where('peternaks.kab_kota_id', request('kab_kota'));
        }

        if (request('kecamatan')) {
            $query->where('peternaks.kecamatan_id', request('kecamatan'));
        }

        if (request('desa_kel')) {
            $query->where('peternaks.desa_kel_id', request('desa_kel'));
        }

        if (request('search')) {
            $query->where(function ($builder) {
                $builder->where('peternaks.nama', 'like', '%'.request('search').'%')
                    ->orWhere('peternaks.nik', 'like', '%'.request('search').'%');
            });
        }

        return $query;
    }

    private function peternakQueryByUser()
    {
        $user_type = Auth::user()->user_type;
        $peternakQuery = Peternak::query();

        if($user_type == "B"){
            $peternakQuery->where('kab_kota_id', Auth::user()->kab_kota_id);
        }elseif($user_type == "C"){
            $peternakQuery->where('kecamatan_id', Auth::user()->kecamatan_id);
        }

        return $peternakQuery;
    }

    private function ensureCanManageMutasi(): void
    {
        if (Auth::user()->user_type !== 'C') {
            abort(403);
        }
    }
}
