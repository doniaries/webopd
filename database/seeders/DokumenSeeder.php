<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DokumenSeeder extends Seeder
{
    public function run()
    {
        // Sample document data
        $dokumenData = [
            ['judul' => 'Peraturan Daerah No. 1 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Peraturan Bupati No. 2 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Keputusan Bupati No. 3 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Surat Edaran No. 4 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Laporan Tahunan 2023', 'tahun' => '2023'],
            ['judul' => 'Peraturan Daerah No. 5 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Peraturan Bupati No. 6 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Keputusan Bupati No. 7 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Surat Edaran No. 8 Tahun 2023', 'tahun' => '2023'],
            ['judul' => 'Laporan Triwulan I 2023', 'tahun' => '2023'],
        ];

        // Create documents
        foreach ($dokumenData as $data) {
            // Generate a unique slug
            $slug = Str::slug($data['judul']);
            
            // Check if document with this slug already exists
            if (!Dokumen::where('slug', $slug)->exists()) {
                
                // Create document with model's fillable fields
                $dokumen = [
                    'nama_dokumen' => $data['judul'],
                    'slug' => $slug,
                    'deskripsi' => 'Deskripsi untuk ' . $data['judul'],
                    'cover' => 'cover-' . Str::slug($data['judul']) . '.jpg',
                    'file' => 'dokumen/' . Str::random(10) . '.pdf',
                    'tahun_terbit' => $data['tahun'] . '-12-31',
                    'views' => rand(0, 1000),
                    'downloads' => rand(0, 500),
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                Dokumen::create($dokumen);
            }
        }
    }
}
