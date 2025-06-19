<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        // Get all teams
        $teams = Team::all();
        
        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        // Base data for announcements
        $pengumumanData = [
            [
                'judul' => 'Pengumuman Libur Hari Raya Idul Fitri 1445 H',
                'slug' => Str::slug('Pengumuman Libur Hari Raya Idul Fitri 1445 H'),
                'isi' => 'Diberitahukan kepada seluruh pegawai bahwa pada tanggal 10-11 April 2025 kantor akan diliburkan dalam rangka Hari Raya Idul Fitri 1445 H. Selamat merayakan hari raya bersama keluarga.',
                'file' => 'pengumuman-libur-lebaran.pdf',
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'judul' => 'Pengumuman Rapat Rutin Bulanan',
                'slug' => Str::slug('Pengumuman Rapat Rutin Bulanan'),
                'isi' => 'Kami mengundang seluruh kepala bidang untuk menghadiri rapat rutin bulanan yang akan dilaksanakan pada:

Hari/Tanggal: Senin, 2 Juni 2025
Waktu: 09.00 - Selesai
Tempat: Ruang Rapat Lantai 3

Mohon kehadirannya tepat waktu.',
                'file' => 'undangan-rapat-juni.pdf',
                'is_active' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Pendaftaran Pelatihan Dasar CPNS 2025',
                'slug' => Str::slug('Pendaftaran Pelatihan Dasar CPNS 2025'),
                'isi' => 'Diberitahukan kepada seluruh CPNS yang telah lulus seleksi untuk segera melakukan pendaftaran pelatihan dasar CPNS tahun 2025. Pendaftaran dibuka mulai tanggal 1-10 Juni 2025 melalui laman resmi BKD.',
                'file' => 'pengumuman-pelatihan-cpns.pdf',
                'is_active' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        // Create announcements for each team
        foreach ($teams as $team) {
            foreach ($pengumumanData as $data) {
                // Make slug unique by appending team ID
                $uniqueSlug = $data['slug'] . '-' . $team->id;
                
                // Add team-specific data with unique slug
                $pengumuman = array_merge($data, [
                    'slug' => $uniqueSlug,
                    'team_id' => $team->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create the announcement
                Pengumuman::create($pengumuman);
            }
        }
    }
}
