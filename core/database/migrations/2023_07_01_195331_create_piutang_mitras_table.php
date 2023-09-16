<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('piutang_mitra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mitra_id')->unsigned();
            $table->integer('item')->unsigned();
            $table->integer('besar_uang')->unsigned()->nullable();
            $table->enum('jenis_layanan', ['express', 'skh']);
            $table->enum('status', ['belum_bayar', 'sudah_bayar']);
            $table->enum('status_validasi',['belum_validasi', 'tervalidasi']);  
            $table->date('tgl_mulai_piutang')->nullable();
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piutang_mitra');
    }
};
