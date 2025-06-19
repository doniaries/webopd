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
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('caption')->nullable()->comment('Keterangan untuk gambar');
            $table->text('description')->nullable()->comment('Deskripsi lebih detail untuk gambar');
            $table->integer('order')->default(0)->comment('Urutan tampilan gambar');
            $table->boolean('is_featured')->default(false)->comment('Apakah gambar ini ditampilkan di galeri unggulan');
            $table->timestamps();

            // Add indexes
            $table->index('post_id');
            $table->index('order');
            $table->index('is_featured');
            $table->index('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
