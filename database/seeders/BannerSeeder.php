<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua banner yang ada
        Banner::truncate();
        
        // Hapus folder banner lama jika ada
        if (Storage::disk('public')->exists('banners')) {
            Storage::disk('public')->deleteDirectory('banners');
        }
        
        // Buat folder banners
        Storage::disk('public')->makeDirectory('banners');

        // Get all teams
        $teams = Team::all();

        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        // Create banners for each team
        $bannerData = [];
        
        foreach ($teams as $team) {
            for ($i = 1; $i <= 5; $i++) {
                $bannerData[] = [
                    'team_id' => $team->id,
                    'judul' => 'Banner ' . $i . ' - ' . $team->name,
                    'gambar' => '', // String kosong sebagai default
                    'keterangan' => 'Banner promosi untuk ' . $team->name,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        // Insert all banners at once
        Banner::insert($bannerData);

        $this->command->info('Successfully created banners with placeholders for all teams!');
    }
}
