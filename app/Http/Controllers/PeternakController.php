<?php

namespace App\Http\Controllers;

use App\Imports\PeternaksImport;
use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Peternak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PeternakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_type = Auth::user()->user_type;
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;
        if($user_type == "A"){
            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();
            $desa_kel = Desa_kelurahan::all();
            $peternak = Peternak::paginate(25);
            return view('admin.peternak.peternak', ['kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel, 'peternak' => $peternak]);
        }elseif($user_type == "B"){
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            $desa_kel = Desa_kelurahan::all();
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota)->paginate(25);
            return view('admin.peternak.peternak', ['kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel, 'peternak' => $peternak]);
        }elseif($user_type == "C"){
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
            $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
            $peternak = Peternak::where('kecamatan_id', $user_kecamatan)->paginate(25);
            return view('admin.peternak.peternak', ['kab_kota' => $kab_kota, 'kecamatan' => $kecamatan, 'desa_kel' => $desa_kel, 'peternak' => $peternak]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_type = Auth::user()->user_type;

        if($user_type == "A"){
            $kab_kota = Kabupaten_kota::all();  
            return view('admin.peternak.form_peternak', ['kab_kota' => $kab_kota]);
        }elseif($user_type == "B"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            return view('admin.peternak.form_peternak', ['kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
        }elseif($user_type == "C"){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $user_kecamatan = Auth::user()->kecamatan_id;
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
            return view('admin.peternak.form_peternak', ['kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'nik'               => 'required',
                'nama'              => "required|regex:/^[a-zA-Z0-9.'\s]+$/",
                'tempat_lahir'      => "required|regex:/^[a-zA-Z0-9.'\s]+$/",
                'tanggal_lahir'     => 'required|date',
                'jenis_kelamin'     => 'required',
                'kab_kota'          => 'required',
                'kecamatan'         => 'required',
                'desa_kel'          => 'required',
                'alamat'            => "required|regex:/^[a-zA-Z0-9.'\s]+$/",
                'hp'                => 'required|numeric',
                'pekerjaan'         => 'required'
            ]);

            Peternak::create([
                'nik'               => $request->nik,
                'nama'              => $request->nama,
                'tempat_lahir'      => $request->tempat_lahir,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'kab_kota_id'       => $request->kab_kota,
                'kecamatan_id'      => $request->kecamatan,
                'desa_kel_id'       => $request->desa_kel,
                'alamat'            => $request->alamat,
                'hp'                => $request->hp,
                'pekerjaan'         => $request->pekerjaan
            ]);

            return redirect('peternak');
        }catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == 23000){
                return redirect()->back()->withErrors(['primary_key' => 'NIK sudah ada.']);
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
        }
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
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;
        $peternak = Peternak::find($id);
        $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
        $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
        $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
        return view(
            'admin.peternak.edit_peternak', [
                'peternak'=>$peternak,
                'kab_kota'=>$kab_kota,
                'kecamatan'=>$kecamatan,
                'desa_kel'=>$desa_kel
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nik'               => 'required',
            'nama'              => "required|regex:/^[a-zA-Z0-9.'\s]+$/",
            'tempat_lahir'      => "required|regex:/^[a-zA-Z0-9.'\s]+$/",
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required',
            'kab_kota'          => 'required',
            'kecamatan'         => 'required',
            'desa_kel'          => 'required',
            'alamat'            => "required|regex:/^[a-zA-Z0-9.'\s]+$/",
            'hp'                => 'required|numeric',
            'pekerjaan'         => 'required'
        ]);

        $peternak = Peternak::find($id);

        $peternak->nik               = $request->nik;
        $peternak->nama              = $request->nama;
        $peternak->tempat_lahir      = $request->tempat_lahir;
        $peternak->tanggal_lahir     = $request->tanggal_lahir;
        $peternak->jenis_kelamin     = $request->jenis_kelamin;
        $peternak->kab_kota_id       = $request->kab_kota;
        $peternak->kecamatan_id      = $request->kecamatan;
        $peternak->desa_kel_id       = $request->desa_kel;
        $peternak->alamat            = $request->alamat;
        $peternak->hp                = $request->hp;
        $peternak->pekerjaan         = $request->pekerjaan;

        $peternak->update($request->all());
        $peternak->save();

        return redirect('peternak');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peternak = Peternak::find($id);
        $peternak->delete();

        return redirect('peternak');
    }

    public function search(Request $request)
    {
        $user_type = Auth::user()->user_type;
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;

        // retrieving searched data
        $search = $request->search;
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        $ft_desa_kel = $request->desa_kel;
        if($user_type == 'A'){
            $peternak = Peternak::whereNotNull('id');
            if(isset($ft_kab_kota)){
                $peternak = Peternak::where('kab_kota_id', $ft_kab_kota);
            }
            if(isset($ft_kecamatan)){
                $peternak->where('kecamatan_id', $ft_kecamatan);
            }
            if(isset($ft_desa_kel)){
                $peternak->where('desa_kel_id', $ft_desa_kel);
            }

            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();
            $desa_kel = Desa_kelurahan::all();
        }elseif($user_type == 'B'){
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota);
            if(isset($ft_kecamatan)){
                $peternak->where('kecamatan_id', $ft_kecamatan);
            }
            if(isset($ft_desa_kel)){
                $peternak->where('desa_kel_id', $ft_desa_kel);
            }

            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            $desa_kel = Desa_kelurahan::all();
        }elseif($user_type == 'C'){
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota)
                ->where('kecamatan_id', $user_kecamatan);
            if(isset($ft_desa_kel)){
                $peternak->where('desa_kel_id', $ft_desa_kel);
            }

            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
            $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
        }

        if(isset($search)){
            $peternak->where('nama', 'like', "%".$search."%");
        }

        $result = $peternak->paginate(25);

        // return data peternak to view (index)
        return view('admin.peternak.peternak', ['peternak' => $result, 'desa_kel' => $desa_kel, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    public function export(Request $request)
    {
        ob_get_clean();
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data_Peternak.xls");

        $user_type = Auth::user()->user_type;

        // retrieving searched data
        $search = $request->search;
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        $ft_desa_kel = $request->desa_kel;
        if($user_type == 'A'){
            $peternak = Peternak::whereNotNull('id');
            if(isset($ft_kab_kota)){
                $peternak->where('kab_kota_id', $ft_kab_kota);
            }
            if(isset($ft_kecamatan)){
                $peternak->where('kecamatan_id', $ft_kecamatan);
            }
            if(isset($ft_desa_kel)){
                $peternak->where('desa_kel_id', $ft_desa_kel);
            }

            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();
            $desa_kel = Desa_kelurahan::all();
        }elseif($user_type == 'B'){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota);
            if(isset($ft_kecamatan)){
                $peternak->where('kecamatan_id', $ft_kecamatan);
            }
            if(isset($ft_desa_kel)){
                $peternak->where('desa_kel_id', $ft_desa_kel);
            }

            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            $desa_kel = Desa_kelurahan::all();

            foreach($kab_kota as $kb_kt){
            if($kb_kt->id == $ft_kab_kota || $kb_kt->id == $user_kab_kota){
                $ft_kab_kota_nama = $kb_kt->nama_kab_kota;
                $user_kab_kota_nama = $kb_kt->nama_kab_kota;
            }
        }
        }elseif($user_type == 'C'){
            $user_kab_kota = Auth::user()->kab_kota_id;
            $user_kecamatan = Auth::user()->kecamatan_id;
            $peternak = Peternak::where('kab_kota_id', $user_kab_kota)
                ->where('kecamatan_id', $user_kecamatan);
            if(isset($ft_desa_kel)){
                $peternak->where('desa_kel_id', $ft_desa_kel);
            }

            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
            $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();

            foreach($kab_kota as $kb_kt){
                if($kb_kt->id == $ft_kab_kota || $kb_kt->id == $user_kab_kota){
                    $ft_kab_kota_nama = $kb_kt->nama_kab_kota;
                    $user_kab_kota_nama = $kb_kt->nama_kab_kota;
                }
            }

            foreach($kecamatan as $kcm){
                if($kcm->id == $ft_kecamatan || $kcm->id == $user_kecamatan){
                    $ft_kecamatan_nama = $kcm->nama_kecamatan;
                    $user_kecamatan_nama = $kcm->nama_kecamatan;
                }
            }
        }

        if(isset($search)){
            $peternak->where('nama', 'like', "%".$search."%");
        }

        $result = $peternak->get();
        
        echo '<center><h1>Data Peternak</h1></center>';
        echo 'Provinsi: Nusa Tenggara Barat<br>';
        if($user_type == "A"){
            if(isset($ft_kab_kota)){
                echo 'Kabupaten/Kota: '.$ft_kab_kota_nama.'<br>';
            }
            if(isset($ft_kecamatan)){
                echo 'Kecamatan: '.$ft_kecamatan_nama.'<br>';
            }
            if(isset($ft_desa_kel)){
                echo 'Desa/Kelurahan: '.$ft_desa_kel.'<br>';
            }
        }elseif($user_type == "B"){
            echo 'Kabupaten/Kota: '.$user_kab_kota_nama.'<br>';
        }elseif($user_type == "C"){
            echo 'Kabupaten/Kota: '.$user_kab_kota_nama.'<br>';
            echo 'Kecamatan: '.$user_kecamatan_nama.'<br>';
        }

        echo '<table class="table table-hover text-nowrap" border="1">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Pekerjaan</th>
                <th>No. Hp</th>
                <th>Alamat</th>
                <th>Desa/Kelurahan</th>
                <th>Kecamatan</th>
                <th>Kabupaten/Kota</th>
            </tr>
            </thead>
            <tbody>';
                $no = 1;
                foreach($result as $p){
                    if($p == ''){
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
                        </tr>';
                    }else{
                        echo '<tr>
                            <td>'.$no++.'</td>
                            <td>'.$p->id."</td>
                            <td>'".$p->nik.'</td>
                            <td>'.$p->nama.'</td>
                            <td>'.$p->tempat_lahir.'</td>
                            <td>'.$p->tanggal_lahir.'</td>
                            <td>';
                                if($p->jenis_kelamin == 1){
                                    echo 'Laki-laki';
                                }elseif($p->jenis_kelamin == 2){
                                    echo 'Perempuan';
                                }
                            echo '</td>
                            <td>';
                                if($p->pekerjaan == 1){
                                    echo 'ASN/TNI/Polri';
                                }elseif($p->pekerjaan == 2){
                                    echo 'Peternak';
                                }elseif($p->pekerjaan == 3){
                                    echo 'Petani';
                                }elseif($p->pekerjaan == 4){
                                    echo 'Swasta';
                                }elseif($p->pekerjaan == 5){
                                    echo 'Wiraswasta';
                                }elseif($p->pekerjaan == 6){
                                    echo 'Pensiunan ASN/TNI/Polri';
                                }elseif($p->pekerjaan == 7){
                                    echo 'Tidak Bekerja';
                                }
                            echo '</td>
                            <td>'.$p->hp.'</td>
                            <td>'.$p->alamat.'</td>
                            <td>';
                                foreach($desa_kel as $dk){
                                    if($p->desa_kel_id == $dk->id){
                                        echo $dk->nama_desa_kel;
                                    }
                                }
                            echo '</td>
                            <td>';
                                foreach($kecamatan as $kc){
                                    if($p->kecamatan_id == $kc->id){
                                        echo $kc->nama_kecamatan;
                                    }
                                }
                            echo '</td>
                            <td>';
                                foreach($kab_kota as $kab_kt){
                                    if($p->kab_kota_id == $kab_kt->id){
                                        echo $kab_kt->nama_kab_kota;
                                    }
                                }
                            echo '</td>
                        </tr>';
                    }
                }
            echo '</tbody>';
        echo '</table>';
    }

    public function import(Request $request)
    {
        try{
                $validated = $request->validate([
                'file' => 'mimes:xls,xlsx'
            ]);

            Excel::import(new PeternaksImport(), $request->file('file'));
            return redirect('peternak');
        }catch(\Illuminate\Database\QueryException $e){
            // if($e->getCode() == 23000){
            //     return redirect()->back()->withErrors(['primary_key' => 'NIK sudah ada.']);
            // }
            // return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
            return $e;
        }
    }    
}
