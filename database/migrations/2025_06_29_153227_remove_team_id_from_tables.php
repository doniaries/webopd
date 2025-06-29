<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove team_id from all relevant tables
        $tables = [
            'unit_kerjas',
            'visi_misis',
            'sambutan_pimpinans',
            'banners',
            'sliders',
            'informasis',
            'produk_hukums',
            'infografis',
            'dokumens',
            'agenda_kegiatans',
            'external_links',
        ];

        // Remove team_id from all tables
        foreach ($tables as $tableName) {
            if (Schema::hasColumn($tableName, 'team_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (DB::getDriverName() !== 'sqlite') {
                        $table->dropForeign([$tableName . '_team_id_foreign']);
                    }
                    $table->dropColumn('team_id');
                });
            }
        }

        // Remove the teams table if it exists
        Schema::dropIfExists('teams');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive operation and cannot be fully reversed
        // Recreating the teams table structure for reference
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name');
            $table->boolean('personal_team');
            $table->timestamps();
        });

        // Note: The team_id columns and foreign keys would need to be recreated manually
        // for each table if you need to rollback this migration
    }
};
