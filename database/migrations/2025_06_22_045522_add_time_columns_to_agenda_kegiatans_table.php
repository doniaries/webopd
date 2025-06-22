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
        Schema::table('agenda_kegiatans', function (Blueprint $table) {
            $table->time('waktu_mulai')->nullable()->after('dari_tanggal');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->string('penyelenggara')->nullable()->after('tempat')->comment('Akan diisi otomatis dengan nama tim jika kosong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda_kegiatans', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai', 'penyelenggara']);
        });
    }
};
