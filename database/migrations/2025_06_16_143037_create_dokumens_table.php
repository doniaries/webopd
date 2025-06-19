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
            $table->softDeletes();

            $table->timestamps();

            // Add composite unique constraints
            $table->unique(['team_id', 'slug']);
            
            // Add indexes for better performance
            $table->index('team_id');
            $table->index('nama_dokumen');
            $table->index('slug');
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
