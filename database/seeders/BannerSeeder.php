<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    // Define a simple placeholder structure
    private $placeholderData = [
        'type' => 'placeholder',
        'bg_color' => 'bg-gray-200',
        'text' => 'Tidak ada gambar',
        'icon' => 'image-x'
    ];

    public function run(): void
    {
        // Get all teams
        $teams = Team::all();

        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        // Create banners for each team
        foreach ($teams as $team) {
            for ($i = 1; $i <= 5; $i++) {
                // Encode the placeholder data as JSON
                $placeholderJson = json_encode($this->placeholderData);

                // Create the banner with the placeholder data
                Banner::create([
                    'team_id' => $team->id,
                    'judul' => 'Banner ' . $i . ' - ' . $team->name,
                    'gambar' => $placeholderJson,
                    'keterangan' => 'Banner promosi untuk ' . $team->name,
                    'is_active' => true
                ]);
            }
        }

        $this->command->info('Successfully created banners with placeholders for all teams!');
    }
}
