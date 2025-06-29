<?php

namespace Database\Seeders;

use App\Models\Infografis;
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
        // Sample infographic data
        $infografisData = [
            [
                'judul' => 'Infografis Pertumbuhan Ekonomi',
                'deskripsi' => 'Data pertumbuhan ekonomi tahun 2023',
                'gambar' => 'infografis-ekonomi.jpg',
                'status' => 'publik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Infografis Kesehatan Masyarakat',
                'deskripsi' => 'Data kesehatan masyarakat tahun 2023',
                'gambar' => 'infografis-kesehatan.jpg',
                'status' => 'publik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Infografis Pendidikan',
                'deskripsi' => 'Data pendidikan tahun 2023',
                'gambar' => 'infografis-pendidikan.jpg',
                'status' => 'publik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Create infographics
        foreach ($infografisData as $data) {
            $slug = Str::slug($data['judul']);
            
            // Check if an infographic with the same title already exists
            $exists = Infografis::where('slug', $slug)->exists();

            if (!$exists) {
                Infografis::create(array_merge($data, ['slug' => $slug]));
            }
        }
        
        $this->command->info('Successfully created infographics!');
    }
}
