<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('piutang_mitra', function (Blueprint $table) {
    //         //
    //     });
    // }

        public function up(): void
    {
        DB::table('piutang_mitra')
            ->where('jenis_layanan', '<>', 'express')
            ->where('jenis_layanan', '<>', 'skh')
            ->update(['jenis_layanan' => 'express']);
            DB::table('piutang_mitra')
            ->where('status', 'pending')
            ->update(['status' => 'belum_bayar']);
            DB::table('piutang_mitra')
            ->where('status_validasi', 'pending')
            ->update(['status_validasi' => 'belum_validasi']);
        
    }

    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('piutang_mitra', function (Blueprint $table) {
            //
        });
    }
};
