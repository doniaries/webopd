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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('foto_utama')->nullable()->comment('Foto utama/cover untuk postingan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->integer('views')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index()->comment('Unggulan');
            $table->timestamps();
            $table->softDeletes();


            // Add indexes for better performance
            $table->index('status');
            $table->index('published_at');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('foto_utama');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
