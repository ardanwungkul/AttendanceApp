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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->string('karyawan_nip',9);
            $table->foreign('karyawan_nip')->references('nip')->on('karyawans')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('total_gaji');
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->enum('tipe_pembayaran',['transfer','tunai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
