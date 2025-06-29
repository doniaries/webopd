<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SliderSeeder extends Seeder
{
    public function run()
    {
        // Create sliders if they don't exist
        $sliders = [
            [
                'judul' => 'Selamat Datang di Website Resmi',
                'deskripsi' => 'Website resmi Pemerintah Daerah Kabupaten Sijunjung',
                'urutan' => 1,
                'status' => 'aktif',
                'gambar' => 'slider1.jpg',
                'tautan' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Layanan Publik Terpadu',
                'deskripsi' => 'Satu pintu pelayanan publik yang cepat dan transparan',
                'urutan' => 2,
                'status' => 'aktif',
                'gambar' => 'slider2.jpg',
                'tautan' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Informasi Terkini',
                'deskripsi' => 'Dapatkan informasi terbaru seputar Pemerintah Kabupaten Sijunjung',
                'urutan' => 3,
                'status' => 'aktif',
                'gambar' => 'slider3.jpg',
                'tautan' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($sliders as $slider) {
            // Check if slider with this order already exists
            $exists = Slider::where('urutan', $slider['urutan'])->exists();

            if (!$exists) {
                Slider::create($slider);
            }
        }

        $this->command->info('Sliders seeded successfully!');
    }
}