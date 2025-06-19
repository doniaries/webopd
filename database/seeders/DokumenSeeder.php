<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DokumenSeeder extends Seeder
{
    public function run()
    {
        // Get all teams
        $teams = Team::all();
        
        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        // Base data for documents
        $dokumenData = [
            [
                'nama_dokumen' => 'Laporan Kinerja Pemerintah Daerah 2024',
                'slug' => Str::slug('Laporan Kinerja Pemerintah Daerah 2024'),
                'deskripsi' => 'Laporan kinerja Pemerintah Daerah tahun 2024 yang berisi capaian-capaian pembangunan selama tahun berjalan.',
                'cover' => 'cover-lkjp-2024.jpg',
                'tahun_terbit' => '2024-12-31',
                'file' => 'lkjp-2024.pdf',
            ],
            [
                'nama_dokumen' => 'Laporan Keuangan Pemerintah Daerah 2024',
                'slug' => Str::slug('Laporan Keuangan Pemerintah Daerah 2024'),
                'deskripsi' => 'Laporan keuangan Pemerintah Daerah tahun 2024 yang telah diaudit oleh BPK.',
                'cover' => 'cover-lkpd-2024.jpg',
                'tahun_terbit' => '2024-12-31',
                'file' => 'lkpd-2024.pdf',
            ],
            [
                'nama_dokumen' => 'Rencana Kerja Pemerintah Daerah 2025',
                'slug' => Str::slug('Rencana Kerja Pemerintah Daerah 2025'),
                'deskripsi' => 'Dokumen perencanaan pembangunan daerah tahun 2025 yang berisi program dan kegiatan pembangunan.',
                'cover' => 'cover-rkpd-2025.jpg',
                'tahun_terbit' => '2024-12-15',
                'file' => 'rkpd-2025.pdf',
            ],
        ];

        // Create documents for each team
        foreach ($teams as $team) {
            foreach ($dokumenData as $data) {
                // Check if document with this slug already exists for this team
                if (!Dokumen::where('team_id', $team->id)
                    ->where('slug', $data['slug'])
                    ->exists()) {
                    
                    // Add team-specific data
                    $dokumen = array_merge($data, [
                        'team_id' => $team->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Create the document
                    Dokumen::create($dokumen);
                }
            }
        }
    }
}
