<?php

namespace Database\Seeders;

use App\Models\Infografis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfografisSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Infografis::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Sample infographic data
        $infografisData = [
            [
                'judul' => 'Infografis Pertumbuhan Ekonomi',
                'gambar' => 'image/infografis/ekonomi.jpg',
                'kategori' => 'Ekonomi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Infografis Kesehatan Masyarakat',
                'gambar' => 'image/infografis/kesehatan.jpg',
                'kategori' => 'Kesehatan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Infografis Pendidikan',
                'gambar' => 'image/infografis/pendidikan.jpg',
                'kategori' => 'Pendidikan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert infographics
        foreach ($infografisData as $data) {
            Infografis::firstOrCreate(
                ['judul' => $data['judul']],
                $data
            );
        }

        $this->command->info('Infografis data has been seeded!');
    }
}
