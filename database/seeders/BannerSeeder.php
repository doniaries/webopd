<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua banner yang ada
        Banner::truncate();
        
        // Create banners with default placeholder image
        $bannerTitles = [
            'Selamat Datang di Website Resmi',
            'Layanan Publik Terpadu',
            'Informasi Terkini',
            'Pengumuman Penting',
            'Berita Terbaru'
        ];

        foreach ($bannerTitles as $index => $title) {
            Banner::firstOrCreate(
                ['judul' => $title],
                [
                    'deskripsi' => 'Deskripsi untuk banner ' . ($index + 1),
                    'gambar' => 'image/placeholder.jpg',
                    'link' => '#',
                    'urutan' => $index + 1,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Successfully created banners!');
    }
}
