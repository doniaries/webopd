<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tag::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Common tags
        $tags = [
            'Teknologi',
            'Kesehatan',
            'Pendidikan',
            'Olahraga',
            'Politik',
            'Sosial',
            'Lingkungan',
            'Pariwisata',
            'Otomotif',
            'Agama',
            'Teknologi Informasi',
            'Pemerintahan',
            'Peraturan',
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['name' => $tagName],
                [
                    'slug' => Str::slug($tagName),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
