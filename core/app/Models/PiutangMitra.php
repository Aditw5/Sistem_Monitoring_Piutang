<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiutangMitra extends Model
{
    use HasFactory;

    
    protected $table = 'piutang_mitra'; // Nama tabel yang sesuai

    protected $fillable = [
        'mitra_id',
        'item',
        'besar_uang',
        'jenis_layanan',
        'status',
        'status_validasi',
        'tgl_mulai_piutang',
        'tgl_jatuh_tempo',
        
    ];


    public function mitra(){
        return $this->belongsTo(Mitra::class);
    }

}
