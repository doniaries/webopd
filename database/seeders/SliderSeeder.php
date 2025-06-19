<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SliderSeeder extends Seeder
{
    public function run()
    {
        // Get the first team or create one if none exists
        $team = Team::first();
        
        if (!$team) {
            $this->command->warn('No teams found. Creating a default team...');
            $team = Team::create([
                'name' => 'Default Team',
                'personal_team' => true,
                'user_id' => 1, // Assuming user with ID 1 exists
            ]);
        }
        
        $sliderData = [
            [
                'judul' => 'Selamat Datang di Portal Resmi',
                'deskripsi' => 'Portal resmi untuk informasi dan layanan publik terkini.',
                'gambar' => 'https://placehold.co/1200x600/007bff/ffffff/png?text=Selamat+Datang',
                'url' => '/berita',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'judul' => 'Informasi Terbaru',
                'deskripsi' => 'Dapatkan informasi terbaru dan pengumuman penting dari kami.',
                'gambar' => 'https://placehold.co/1200x600/28a745/ffffff/png?text=Informasi+Terbaru',
                'url' => '/pengumuman',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'judul' => 'Agenda Kegiatan',
                'deskripsi' => 'Ikuti berbagai kegiatan dan acara yang akan datang.',
                'gambar' => 'https://placehold.co/1200x600/dc3545/ffffff/png?text=Agenda+Kegiatan',
                'url' => '/agenda-kegiatan',
                'urutan' => 3,
                'is_active' => true,
            ],
        ];
        
        // Create sliders for the team
        foreach ($sliderData as $data) {
            Slider::create(array_merge($data, [
                'team_id' => $team->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
        
        $this->command->info('Sliders seeded successfully!');
    }
}