<?php

namespace App\Http\Controllers;


use App\Models\Desa_kelurahan;
use App\Models\Kecamatan;
use App\Models\Peternak;

class DaerahController extends Controller
{
    public function index()
    {
        $data = $_POST['data'];
        $id = $_POST['id'];

        if($data == "kecamatan"){
            echo('<select name="kecamatan" id="kecamatan">
                <option value="">Pilih Kecamatan</option>
            ');

            $daerah = Kecamatan::where('kab_kota_id', $id)->get();

            foreach($daerah as $d){
                echo('<option value="'.$d->id.'">'.$d->nama_kecamatan.'</option>');
            }
            echo('</select>');
        }else if($data == "desa_kel"){
            echo('<select name="desa_kel" id="desa_kel">
                <option value="">Pilih Desa/Kelurahan</option>
            ');

            $daerah = Desa_kelurahan::where('kecamatan_id', $id)->get();

            foreach($daerah as $d){
                echo('<option value="'.$d->id.'">'.$d->nama_desa_kel.'</option>');
            }
            echo('</select>');
        }else if($data == "lokasi"){
            $peternak = Peternak::where('id', $id)->first();
            echo('<select name="desa_kel" id="desa_kel">
                <option value="">Pilih Desa/Kelurahan</option>
            ');
            foreach($peternak as $d){
                echo('<option value="'.$d->id.'">'.$d->nama_desa_kel.'</option>');
            }
            echo('</select>');
        }
    }
}
