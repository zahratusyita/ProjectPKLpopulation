<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa_kelurahan extends Model
{
    use HasFactory;
    
    public function User(){
        return $this->hasMany('App\Models\User');
    }

    public function Peternak(){
        return $this->hasMany('App\Models\Peternak');
    }
    
    public function Kecamatan(){
        return $this->belongsTo('App\Models\Kecamatan');
    }
}
