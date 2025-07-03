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
                'id' => 1,
                'gambar' => 'assets/images/placeholder2.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'gambar' => 'assets/images/placeholder2.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'gambar' => 'assets/images/placeholder2.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert banners
        foreach ($banners as $banner) {
            Banner::firstOrCreate(
                $banner
            );
        }

        $this->command->info('Successfully created banners!');
    }
}
