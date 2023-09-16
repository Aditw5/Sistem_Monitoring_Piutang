<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;
    
    protected $table = 'mitra'; // Nama tabel yang sesuai

    protected $fillable = [
        'name',
        'no_kontrak',
        'nomor_hp',
        'masa_kontrak',
    ];

    public function piutang(){
        return $this->hasMany(PiutangMitra::class);
    }
}
