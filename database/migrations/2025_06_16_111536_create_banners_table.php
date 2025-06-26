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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('judul');
            $table->string('keterangan')->nullable();
            $table->string('gambar')->default('')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('team_id');
            $table->index('judul');
            $table->index('keterangan');
            $table->index('gambar');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
