<?php

namespace App\Http\Controllers;

use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\Peternak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeternakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_type = Auth::user()->user_type;
        $kab_kota = Auth::user()->kab_kota_id;
        $kecamatan = Auth::user()->kecamatan_id;
        if($user_type == "A"){
            $peternak = Peternak::paginate(25);
            $desa_kel = Desa_kelurahan::all();
        }elseif($user_type == "B"){
            $peternak = Peternak::where('kab_kota_id', $kab_kota)->paginate(25);
            $kecamatan = Kecamatan::where('kab_kota_id', $kecamatan)->get();
        }elseif($user_type == "C"){
            $desa_kel = Desa_kelurahan::where('kecamatan_id', $kecamatan)->get();
            $peternak = Peternak::where('kecamatan_id', $kecamatan)->paginate(25);
        }
        
        $kab_kota = Kabupaten_kota::all();
        return view('admin.peternak.peternak', ['peternak' => $peternak, 'desa_kel' => $desa_kel, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_type = Auth::user()->user_type;
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;
        if($user_type == "A"){
            $kab_kota = Kabupaten_kota::all();  
            return view('admin.peternak.form_peternak', ['kab_kota' => $kab_kota]);
        }elseif($user_type == "B"){
            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
            return view('admin.peternak.form_peternak', ['kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
        }elseif($user_type == "C"){
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
        $validated = $request->validate([
            'nik'               => 'required',
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required',
            'kab_kota'          => 'required',
            'kecamatan'         => 'required',
            'desa_kel'          => 'required',
            'alamat'            => 'required',
            'hp'                => 'required',
            'pekerjaan'         => 'required'
        ]);

        Peternak::create([
            'nik'               => $request->nik,
            'nama'              => $request->nama,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'kab_kota_id'       => $request->kab_kota,
            'kecamatan_id'      => $request->kecamatan,
            'desa_kel_id'       => $request->desa_kel,
            'alamat'            => $request->alamat,
            'hp'                => $request->hp,
            'pekerjaan'         => $request->pekerjaan
        ]);

        return redirect('peternak');
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
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required',
            'kab_kota'          => 'required',
            'kecamatan'         => 'required',
            'desa_kel'          => 'required',
            'alamat'            => 'required',
            'hp'                => 'required',
            'pekerjaan'         => 'required'
        ]);

        $peternak = Peternak::find($id);

        $peternak->nik               = $request->nik;
        $peternak->nama              = $request->nama;
        $peternak->tempat_lahir      = $request->tempat_lahir;
        $peternak->tanggal_lahir     = $request->tanggal_lahir;
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
        $user_type = Auth::user()->user_type;
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;

        // retrieving searched data
        $search = $request->search;
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        $ft_desa_kel = $request->desa_kel;
        if(empty($search)){
            $search = '';
        }
        if($user_type == 'A'){
            if(empty($ft_kab_kota)){
                $ft_kab_kota = '';
            }
            if(empty($ft_kecamatan)){
                $ft_kecamatan = '';
            }
            if(empty($ft_desa_kel)){
                $ft_desa_kel = '';
            }
        }elseif($user_type == 'B'){
            $ft_kab_kota = $user_kab_kota;
            if(empty($ft_kecamatan)){
                $ft_kecamatan = '';
            }
            if(empty($ft_desa_kel)){
                $ft_desa_kel = '';
            }
        }elseif($user_type == 'C'){
            $ft_kab_kota = $user_kab_kota;
            $ft_kecamatan = $user_kecamatan;
            if(empty($ft_desa_kel)){
                $ft_desa_kel = '';
            }
            $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
        }

        // get data from table peternak
        $peternak = Peternak::where('nama', 'like', "%".$search."%")
                    ->where('kab_kota_id', $ft_kab_kota)
                    ->where('kecamatan_id', $ft_kecamatan)
                    ->where('desa_kel_id', $ft_desa_kel)
                    ->paginate(25);

        // return data peternak to view (index)
        $kab_kota = Kabupaten_kota::all();
        $kecamatan = Kecamatan::all();
        return view('admin.peternak.peternak', ['peternak' => $peternak, 'desa_kel' => $desa_kel, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    public function export()
    {
        ob_get_clean();
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data Peternak.xls");

        $user_type = Auth::user()->user_type;
        $user_type = Auth::user()->user_type;
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;

        // retrieving searched data
        $search = $_REQUEST['search'];
        $ft_kab_kota = $_REQUEST['kab_kota'];
        $ft_kecamatan = $_REQUEST['kecamatan'];
        $ft_desa_kel = $_REQUEST['desa_kel'];
        if(empty($search)){
            $search = '';
        }
        if($user_type == 'A'){
            if(empty($ft_kab_kota)){
                $ft_kab_kota = '';
            }
            if(empty($ft_kecamatan)){
                $ft_kecamatan = '';
            }
            if(empty($ft_desa_kel)){
                $ft_desa_kel = '';
            }

            // get data from table peternak
            $peternak = Peternak::where('nama', 'like', "%".$search."%")
            ->where('kab_kota_id', $ft_kab_kota)
            ->where('kecamatan_id', $ft_kecamatan)
            ->where('desa_kel_id', $ft_desa_kel)
            ->get();
        }elseif($user_type == 'B'){
            $ft_kab_kota = $user_kab_kota;
            if(empty($ft_kecamatan)){
                $ft_kecamatan = '';
            }
            if(empty($ft_desa_kel)){
                $ft_desa_kel = '';
            }

            // get data from table peternak
            $peternak = Peternak::where('nama', 'like', "%".$search."%")
            ->where('kab_kota_id', $ft_kab_kota)
            ->where('kecamatan_id', $ft_kecamatan)
            ->where('desa_kel_id', $ft_desa_kel)
            ->get();
        }elseif($user_type == 'C'){
            $ft_kab_kota = $user_kab_kota;
            $ft_kecamatan = $user_kecamatan;
            if(empty($ft_desa_kel)){
                $ft_desa_kel = '';
            }

            // get data from table peternak
            $peternak = Peternak::where('nama', 'like', "%".$search."%")
            ->where('kab_kota_id', $ft_kab_kota)
            ->where('kecamatan_id', $ft_kecamatan)
            ->where('desa_kel_id', $ft_desa_kel)
            ->get();
            // $desa_kel = Desa_kelurahan::where('kecamatan_id', $user_kecamatan)->get();
            echo $peternak;
        }
        
        // $kab_kota = Kabupaten_kota::all();
        // $kecamatan = Kecamatan::all();
        // $desa_kel = Desa_kelurahan::all();
        
        // echo '<center><h1>Data Peternak</h1></center>';

        // echo '<table class="table table-hover text-nowrap" border="1">
        //     <thead>
        //     <tr>
        //         <th>No.</th>
        //         <th>NIK</th>
        //         <th>Nama</th>
        //         <th>Tempat Lahir</th>
        //         <th>Tanggal Lahir</th>
        //         <th>No. Hp</th>
        //         <th>Alamat</th>
        //         <th>Desa/Kelurahan</th>
        //         <th>Kecamatan</th>
        //         <th>Kabupaten/Kota</th>
        //     </tr>
        //     </thead>
        //     <tbody>';
        //         foreach($peternak as $p){
        //             if($p == ''){
        //                 echo '<tr>
        //                     <td>1</td>
        //                     <td>2</td>
        //                     <td>3</td>
        //                     <td>4</td>
        //                     <td>5</td>
        //                     <td>6</td>
        //                     <td>7</td>
        //                     <td>8</td>
        //                     <td>9</td>
        //                     <td>10</td>
        //                 </tr>';
        //             }else{
        //                 echo '<tr>
        //                     <td>'.$p->id.'</td>
        //                     <td>'.$p->nik.'</td>
        //                     <td>'.$p->nama.'</td>
        //                     <td>'.$p->tempat_lahir.'</td>
        //                     <td>'.$p->tanggal_lahir.'</td>
        //                     <td>'.$p->hp.'</td>
        //                     <td>'.$p->alamat.'</td>
        //                     <td>';
        //                         foreach($desa_kel as $dk){
        //                             if($p->desa_kel_id == $dk->id){
        //                                 echo $dk->nama_desa_kel;
        //                             }
        //                         }
        //                     echo '</td>'; 
        //                     echo '<td>';
        //                         foreach($kecamatan as $kec){
        //                             if($p->kecamatan_id == $kec->id){
        //                                 echo $kec->nama_kecamatan;
        //                             }
        //                         }
        //                     echo '</td>';
        //                     echo '<td>';
        //                         foreach($kab_kota as $kab_kt){
        //                             if($p->kab_kota_id == $kab_kt->id){
        //                                 echo $kab_kt->nama_kab_kota;
        //                             }
        //                         }
        //                     echo '</td>';
        //                 echo '</tr>';
        //             }
        //         }
        //     echo '</tbody>';
        // echo '</table>';
    }
}
