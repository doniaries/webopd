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
        // Get or create default team
        $team = Team::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Tim Utama',
                'user_id' => 1,
                'personal_team' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        
        $this->command->info('Using team: ' . $team->name . ' (ID: ' . $team->id . ')');

        // Base data for announcements with different published dates
        $pengumumanData = [
            [
                'judul' => 'Pengumuman Libur Hari Raya Idul Fitri 1445 H',
                'slug' => Str::slug('Pengumuman Libur Hari Raya Idul Fitri 1445 H'),
                'isi' => 'Diberitahukan kepada seluruh pegawai bahwa pada tanggal 10-11 April 2025 kantor akan diliburkan dalam rangka Hari Raya Idul Fitri 1445 H. Selamat merayakan hari raya bersama keluarga.',
                'file' => 'pengumuman-libur-lebaran.pdf',
                'is_active' => true,
                'published_at' => now()->subMonths(2),
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
            [
                'judul' => 'Pemadaman Listrik Berkala',
                'slug' => Str::slug('Pemadaman Listrik Berkala'),
                'isi' => 'Diberitahukan akan ada pemadaman listrik berkala pada hari Sabtu, 15 Juni 2025 pukul 09.00-15.00 WIB untuk perawatan jaringan. Mohon untuk mempersiapkan perangkat cadangan dan menyimpan data-data penting sebelumnya.',
                'file' => 'pemadaman-listrik.pdf',
                'is_active' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'judul' => 'Pembaruan Aplikasi E-Office',
                'slug' => Str::slug('Pembaruan Aplikasi E-Office'),
                'isi' => 'Akan dilakukan pembaruan aplikasi E-Office pada hari Jumat, 14 Juni 2025 pukul 23.00-03.00 WIB. Selama proses pembaruan, akses ke aplikasi E-Office tidak dapat dilakukan. Harap menyelesaikan pekerjaan yang berhubungan dengan E-Office sebelum jadwal tersebut.',
                'file' => 'pembaruan-eoffice.pdf',
                'is_active' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Pengumuman Penerimaan Peserta Magang',
                'slug' => Str::slug('Pengumuman Penerimaan Peserta Magang'),
                'isi' => 'Diumumkan kepada seluruh peserta magang yang telah mendaftar, bahwa daftar peserta yang diterima dapat dilihat di bagian SDM mulai tanggal 10 Juni 2025. Bagi yang diterima diharapkan menghadiri pembekalan pada tanggal 17 Juni 2025 pukul 09.00 WIB di Ruang Rapat Utama.',
                'file' => 'pengumuman-magang.pdf',
                'is_active' => true,
                'published_at' => now()->subDays(7),
            ],
        ];

        // Create announcements for team 1
        foreach ($pengumumanData as $data) {
            // Check if pengumuman with this slug already exists for this team
            $existing = Pengumuman::where('slug', $data['slug'])
                                ->where('team_id', $team->id)
                                ->exists();
            
            if (!$existing) {
                // Create new pengumuman with team_id
                Pengumuman::create([
                    'judul' => $data['judul'],
                    'slug' => $data['slug'],
                    'isi' => $data['isi'],
                    'file' => $data['file'],
                    'is_active' => $data['is_active'],
                    'published_at' => $data['published_at'],
                    'team_id' => $team->id,
                ]);
            }
        }
    }
}
