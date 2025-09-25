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
        // Ensure the roles table has the correct structure
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'guard_name')) {
                $table->string('guard_name')->default('web');
            }
            if (!Schema::hasColumn('roles', 'description')) {
                $table->text('description')->nullable();
            }
        });

        // Insert default roles if they don't exist
        $roles = [
            [
                'name' => 'administrator',
                'guard_name' => 'web',
                'description' => 'Has full control over the entire site',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'editor',
                'guard_name' => 'web',
                'description' => 'Can manage all posts and pages',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'author',
                'guard_name' => 'web',
                'description' => 'Can publish and manage their own posts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'contributor',
                'guard_name' => 'web',
                'description' => 'Can write and edit their own posts but cannot publish',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($roles as $role) {
            if (!DB::table('roles')->where('name', $role['name'])->exists()) {
                DB::table('roles')->insert($role);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to rollback as we're only adding columns if they don't exist
        // and not modifying any existing data
    }
};
