<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    public function User(){
        return $this->hasMany('App\Models\User');
    }

    public function Peternak(){
        return $this->hasMany('App\Models\User');
    }

    public function Desa_kelurahan(){
        return $this->hasMany('App\Models\Desa_kelurahan');
    }

    public function Kabupaten_kota(){
        return $this->belongsTo('App\Models\Kabupaten_kota');
    }
}
