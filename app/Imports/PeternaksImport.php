<?php

namespace App\Imports;

use App\Models\Peternak;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeternaksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            return new Peternak([
                'nik' => $row['nik'],
                'nama' => $row['nama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d'),
                'jenis_kelamin' => $row['jenis_kelamin'],
                'kab_kota_id' => $row['kab_kota_id'],
                'kecamatan_id' => $row['kecamatan_id'],
                'desa_kel_id' => $row['desa_kel_id'],
                'alamat' => $row['alamat'],
                'hp' => $row['hp'],
                'pekerjaan' => $row['pekerjaan']
            ]);
    }
}
