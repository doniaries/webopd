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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('gambar');
            $table->string('url')->nullable();
            $table->string('button_text')->nullable()->comment('Teks tombol yang akan ditampilkan');
            $table->string('button_url')->nullable()->comment('URL tujuan saat tombol diklik');
            $table->integer('urutan')->unique()->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
