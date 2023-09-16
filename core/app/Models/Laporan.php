<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    public function mitra(){
        return $this->belongsTo(Mitra::class);
    }

    public function piutang_mitra(){
        return $this->belongsTo(PiutangMitra::class);
    }
}
