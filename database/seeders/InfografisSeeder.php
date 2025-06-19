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
    private $imageUrls = [
        'https://img.freepik.com/free-vector/statistics-infographics-template_23-2149018325.jpg?w=740&t=st=1650000000',
        'https://img.freepik.com/free-vector/business-presentation-process-infographics_23-2148894676.jpg?w=740&t=st=1650000000',
        'https://img.freepik.com/free-vector/business-presentation-process-infographics_23-2148894678.jpg?w=740&t=st=1650000000',
        'https://img.freepik.com/free-vector/business-presentation-process-infographics_23-2148894679.jpg?w=740&t=st=1650000000',
        'https://img.freepik.com/free-vector/business-presentation-process-infographics_23-2148894680.jpg?w=740&t=st=1650000000',
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

        // Create directory if not exists
        if (!Storage::disk('public')->exists('infografis')) {
            Storage::disk('public')->makeDirectory('infografis');
        }

        // Create infografis for each team
        foreach ($teams as $team) {
            foreach ($infografisData as $index => $data) {
                $imageUrl = $this->imageUrls[$index % count($this->imageUrls)];
                $imageName = 'infografis-' . Str::slug($data['judul']) . '.jpg';
                $imagePath = 'infografis/' . $imageName;

                // Download and save image
                try {
                    $image = Http::get($imageUrl);
                    Storage::disk('public')->put($imagePath, $image->body());
                } catch (\Exception $e) {
                    $this->command->error('Failed to download image: ' . $e->getMessage());
                    continue;
                }

                Infografis::create([
                    'team_id' => $team->id,
                    'judul' => $data['judul'],
                    'gambar' => $imageName,
                    'kategori' => $data['kategori'],
                    'is_active' => $data['is_active'],
                ]);
            }
        }
        
        $this->command->info('Successfully created infographics for all teams!');
    }
}
