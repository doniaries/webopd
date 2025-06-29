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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('nama_dokumen')->nullable();
            $table->string('slug')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable();
            $table->date('tahun_terbit')->nullable();
            $table->string('file')->nullable();
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->softDeletes();

            $table->timestamps();

            // Add composite unique constraints
            $table->unique(['team_id', 'slug']);

            // Add indexes for better performance
            $table->index('team_id');
            $table->index('nama_dokumen');
            $table->index('slug');
            $table->index('tahun_terbit');
            $table->index('downloads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
