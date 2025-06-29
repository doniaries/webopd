<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Slider::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create sliders
        $sliders = [
            [
                'judul' => 'Selamat Datang di Website Resmi',
                'deskripsi' => 'Website resmi Pemerintah Daerah Kabupaten Sijunjung',
                'gambar' => 'image/placeholder.jpg',
                'url' => '#',
                'button_text' => 'Selengkapnya',
                'button_url' => '#',
                'urutan' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Layanan Publik Terpadu',
                'deskripsi' => 'Satu pintu pelayanan publik yang cepat dan transparan',
                'gambar' => 'image/placeholder.jpg',
                'url' => '#layanan',
                'button_text' => 'Lihat Layanan',
                'button_url' => '#layanan',
                'urutan' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Informasi Terkini',
                'deskripsi' => 'Dapatkan informasi terbaru seputar Pemerintah Kabupaten Sijunjung',
                'gambar' => 'image/placeholder.jpg',
                'url' => '#berita',
                'button_text' => 'Baca Berita',
                'button_url' => '#berita',
                'urutan' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert sliders
        foreach ($sliders as $slider) {
            Slider::firstOrCreate(
                ['judul' => $slider['judul']],
                $slider
            );
        }

        $this->command->info('Sliders seeded successfully!');
    }
}