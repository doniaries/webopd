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
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('kepala_instansi')->nullable();
            $table->text('alamat_instansi')->nullable();
            $table->string('no_telp_instansi', 20)->nullable();
            $table->string('email_instansi')->unique()->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->decimal('latitude', 10, 8)->nullable()->comment('Koordinat latitude untuk peta');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Koordinat longitude untuk peta');
            $table->timestamps();

            // Add indexes
            $table->index('name');
            $table->index('email_instansi');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
