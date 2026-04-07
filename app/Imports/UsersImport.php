<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // If no existing record, create a new record
        return new User([
            'name'          => $row['nama'],
            'email'         => $row['email'],
            'user_type'     => $row['kategori'],
            'password'      => Hash::make($row['password']),
            'kab_kota_id'   => $row['kab_kota_id'],
            'kecamatan_id'  => $row['kecamatan_id']
        ]);
    }
}
