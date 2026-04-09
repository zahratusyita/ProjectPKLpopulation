<?php

namespace App\Http\Controllers;


use App\Models\Desa_kelurahan;
use App\Models\Kecamatan;
use App\Models\Peternak;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->input('data');
        $id = $request->input('id');

        if($data == "kecamatan"){
            $daerah = Kecamatan::where('kab_kota_id', $id)->get();
            $options = '<option value="">Pilih Kecamatan</option>';

            foreach($daerah as $d){
                $options .= '<option value="'.$d->id.'">'.$d->nama_kecamatan.'</option>';
            }

            return response($options);
        }else if($data == "desa_kel"){
            $daerah = Desa_kelurahan::where('kecamatan_id', $id)->get();
            $options = '<option value="">Pilih Desa/Kelurahan</option>';

            foreach($daerah as $d){
                $options .= '<option value="'.$d->id.'">'.$d->nama_desa_kel.'</option>';
            }

            return response($options);
        }else if($data == "lokasi"){
            $peternak = Peternak::where('id', $id)->first();

            if (! $peternak) {
                return response('');
            }

            $lokasi = Desa_kelurahan::find($peternak->desa_kel_id);

            if (! $lokasi) {
                return response('');
            }

            return response('<div class="alert alert-info mb-0">Lokasi peternak: '.$lokasi->nama_desa_kel.'</div>');
        }

        return response('');
    }
}
