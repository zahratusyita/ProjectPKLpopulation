<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten_kota extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasMany('App\Models\User');
    }

    public function kecamatan(){
        return $this->hasMany('App\Models\Kecamatan');
    }

    public function peternak(){
        return $this->hasMany('App\Models\Peternak');
    }
}
