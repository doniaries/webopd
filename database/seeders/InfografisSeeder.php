<?php

namespace Database\Seeders;

use App\Models\Infografis;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class InfografisSeeder extends Seeder
{
    // Simple placeholder data
    private $placeholderData = [
        'type' => 'placeholder',
        'bg_color' => 'bg-gray-200',
        'text' => 'Tidak ada gambar',
        'icon' => 'image-x'
    ];

    public function run()
    {
        // Get all teams
        $teams = Team::all();

        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        $infografisData = [
            [
                'judul' => 'Capaian Kinerja Triwulan I 2025',
                'kategori' => 'Kinerja',
                'is_active' => true,
            ],
            [
                'judul' => 'Alur Pelayanan Perizinan Online',
                'kategori' => 'Pelayanan',
                'is_active' => true,
            ],
            [
                'judul' => 'Infografis APBD 2025',
                'kategori' => 'Keuangan',
                'is_active' => true,
            ],
            [
                'judul' => 'Panduan Layanan Publik',
                'kategori' => 'Pelayanan',
                'is_active' => true,
            ],
            [
                'judul' => 'Statistik Kependudukan 2025',
                'kategori' => 'Kependudukan',
                'is_active' => true,
            ],
        ];

        // Create infografis for each team
        foreach ($teams as $team) {
            foreach ($infografisData as $data) {
                // Encode the placeholder data as JSON
                $placeholderJson = json_encode($this->placeholderData);

                Infografis::create([
                    'team_id' => $team->id,
                    'judul' => $data['judul'],
                    'gambar' => $placeholderJson,
                    'kategori' => $data['kategori'],
                    'is_active' => $data['is_active'],
                ]);
            }
        }
        
        $this->command->info('Successfully created infographics for all teams!');
    }
}
