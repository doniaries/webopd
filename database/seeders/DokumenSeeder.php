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
            ['judul' => 'RKA Dinas Kesehatan Tahun 2024', 'tahun' => '2024'],
            ['judul' => 'RKA Dinas Pendidikan dan Kebudayaan 2024', 'tahun' => '2024'],
            ['judul' => 'Sijunjung Dalam Angka 2023', 'tahun' => '2023'],
            ['judul' => 'Laporan Realisasi Anggaran Dinas PUPR 2023', 'tahun' => '2023'],
            ['judul' => 'Profil Kesehatan Kabupaten Sijunjung 2023', 'tahun' => '2023'],
            ['judul' => 'Statistik Daerah Kabupaten Sijunjung 2023', 'tahun' => '2023'],
            ['judul' => 'Rencana Strategis Dinas PMD 2023-2026', 'tahun' => '2023'],
            ['judul' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah 2023', 'tahun' => '2023'],
            ['judul' => 'Rencana Kerja Pemerintah Daerah 2024', 'tahun' => '2024'],
            ['judul' => 'Laporan Keterangan Pertanggungjawaban Bupati 2023', 'tahun' => '2023'],
            ['judul' => 'RKA Dinas Sosial Tahun 2024', 'tahun' => '2024'],
            ['judul' => 'Indeks Pembangunan Manusia Kabupaten Sijunjung 2023', 'tahun' => '2023'],
            ['judul' => 'Laporan Realisasi Fisik dan Keuangan Triwulan I 2024', 'tahun' => '2024'],
            ['judul' => 'Profil Pendidikan Kabupaten Sijunjung 2023', 'tahun' => '2023'],
            ['judul' => 'Rencana Kerja Dinas Perdagangan dan Perindustrian 2024', 'tahun' => '2024'],
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
