<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        Banner::truncate();
        
        // Create banners with default placeholder image
        $banners = [
            [
                'judul' => 'Selamat Datang di Website Resmi',
                'keterangan' => 'Situs resmi Pemerintah Kabupaten Sijunjung',
                'gambar' => 'image/placeholder.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Layanan Publik Terpadu',
                'keterangan' => 'Layanan terpadu untuk masyarakat',
                'gambar' => 'image/placeholder.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Informasi Terkini',
                'keterangan' => 'Update informasi terbaru dari kami',
                'gambar' => 'image/placeholder.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert banners
        foreach ($banners as $banner) {
            Banner::firstOrCreate(
                ['judul' => $banner['judul']],
                $banner
            );
        }

        $this->command->info('Successfully created banners!');
    }
}
