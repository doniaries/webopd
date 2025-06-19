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
        Schema::create('infografis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('judul')->nullable();
            $table->string('gambar')->nullable();
            $table->string('kategori')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Add composite unique constraint for team_id and judul
            $table->unique(['team_id', 'judul']);
            
            // Add indexes for better performance
            $table->index('judul');
            $table->index('kategori');
            $table->index('is_active');
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infografis');
    }
};
