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
        // Hapus kolom team_id dari tabel posts jika ada
        if (Schema::hasColumn('posts', 'team_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
                $table->dropColumn('team_id');
            });
        }

        // Hapus kolom team_id dari tabel external_links jika ada
        if (Schema::hasColumn('external_links', 'team_id')) {
            Schema::table('external_links', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
                $table->dropColumn('team_id');
            });
        }

        // Hapus kolom current_team_id dari tabel users jika ada
        if (Schema::hasColumn('users', 'current_team_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('current_team_id');
            });
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom team_id ke tabel posts
        if (!Schema::hasColumn('posts', 'team_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->foreignId('team_id')->nullable()->constrained()->onDelete('set null');
            });
        }

        // Kembalikan kolom team_id ke tabel external_links
        if (!Schema::hasColumn('external_links', 'team_id')) {
            Schema::table('external_links', function (Blueprint $table) {
                $table->foreignId('team_id')->nullable()->constrained()->onDelete('set null');
            });
        }

        // Kembalikan kolom current_team_id ke tabel users
        if (!Schema::hasColumn('users', 'current_team_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('current_team_id')->nullable();
            });
        }


    }
};
