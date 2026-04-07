<?php

namespace App\Imports;

use App\Models\Ternak;
// use App\Models\Peternak;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TernaksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $init_val = 0;
        // $now = date('Y');
        // $user_kecamatan = Auth::user()->kecamatan_id;

        // This is where you would check for existing data
        // $existing_ternak = Ternak::where('tahun', $now)->where('peternak_id', $row['peternak_id'])->get();

        // if($existing_ternak){
            // 2. Skip this record and log a message:
            // Log::info('Skipping duplicate record: ' . $row['peternak_id']);
            // return null;

            // 3. Throw an exception if duplicates are not allowed:
            // throw new \Exception('Duplicate record found: ' . $row['peternak_id']);
        //     echo 'Duplicate record found: <br>Id Peternak:' . $row['peternak_id'].' sudah ada.<br>';
        // }else{

            // If no existing record, create a new record
            return new Ternak([
                'peternak_id' => $init_val + $row['peternak_id'],
                'tahun' => $row['tahun'],
                'sapi_anak_jantan' => $init_val + $row['sapi_anak_jantan'],
                'sapi_anak_betina' => $init_val + $row['sapi_anak_betina'],
                'sapi_muda_jantan' => $init_val + $row['sapi_muda_jantan'],
                'sapi_muda_betina' => $init_val + $row['sapi_muda_betina'],
                'sapi_dewasa_jantan' => $init_val + $row['sapi_dewasa_jantan'],
                'sapi_dewasa_betina' => $init_val + $row['sapi_dewasa_betina'],
                'kerbau_anak_jantan' => $init_val + $row['kerbau_anak_jantan'],
                'kerbau_anak_betina' => $init_val + $row['kerbau_anak_betina'],
                'kerbau_muda_jantan' => $init_val + $row['kerbau_muda_jantan'],
                'kerbau_muda_betina' => $init_val + $row['kerbau_muda_betina'],
                'kerbau_dewasa_jantan' => $init_val + $row['kerbau_dewasa_jantan'],
                'kerbau_dewasa_betina' => $init_val + $row['kerbau_dewasa_betina'],
                'kuda_anak_jantan' => $init_val + $row['kuda_anak_jantan'],
                'kuda_anak_betina' => $init_val + $row['kuda_anak_betina'],
                'kuda_muda_jantan' => $init_val + $row['kuda_muda_jantan'],
                'kuda_muda_betina' => $init_val + $row['kuda_muda_betina'],
                'kuda_dewasa_jantan' => $init_val + $row['kuda_dewasa_jantan'],
                'kuda_dewasa_betina' => $init_val + $row['kuda_dewasa_betina'],
                'kambing_anak_jantan' => $init_val + $row['kambing_anak_jantan'],
                'kambing_anak_betina' => $init_val + $row['kambing_anak_betina'],
                'kambing_muda_jantan' => $init_val + $row['kambing_muda_jantan'],
                'kambing_muda_betina' => $init_val + $row['kambing_muda_betina'],
                'kambing_dewasa_jantan' => $init_val + $row['kambing_dewasa_jantan'],
                'kambing_dewasa_betina' => $init_val + $row['kambing_dewasa_betina'],
                'babi_anak_jantan' => $init_val + $row['babi_anak_jantan'],
                'babi_anak_betina' => $init_val + $row['babi_anak_betina'],
                'babi_muda_jantan' => $init_val + $row['babi_muda_jantan'],
                'babi_muda_betina' => $init_val + $row['babi_muda_betina'],
                'babi_dewasa_jantan' => $init_val + $row['babi_dewasa_jantan'],
                'babi_dewasa_betina' => $init_val + $row['babi_dewasa_betina'],
                'domba_anak_jantan' => $init_val + $row['domba_anak_jantan'],
                'domba_anak_betina' => $init_val + $row['domba_anak_betina'],
                'domba_muda_jantan' => $init_val + $row['domba_muda_jantan'],
                'domba_muda_betina' => $init_val + $row['domba_muda_betina'],
                'domba_dewasa_jantan' => $init_val + $row['domba_dewasa_jantan'],
                'domba_dewasa_betina' => $init_val + $row['domba_dewasa_betina'],
                'ayam_ras' => $init_val + $row['ayam_ras'],
                'ayam_buras' => $init_val + $row['ayam_buras'],
                'ayam_petelur' => $init_val + $row['ayam_petelur'],
                'itik' => $init_val + $row['itik'],
                'puyuh' => $init_val + $row['puyuh'],
                'keterangan' => $row['keterangan']
            ]);

            // return redirect('ternak');
        // }
    }
}
