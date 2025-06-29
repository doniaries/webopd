<?php

namespace Database\Seeders;

use App\Models\AgendaKegiatan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgendaKegiatanSeeder extends Seeder
{
    public function run()
    {
        // Sample agenda kegiatan data
        $agendaKegiatanData = [
            [
                'judul' => 'Rapat Koordinasi',
                'deskripsi' => 'Rapat koordinasi bulanan',
                'tempat' => 'Aula Kantor',
                'tanggal_mulai' => Carbon::now()->addDays(1),
                'tanggal_selesai' => Carbon::now()->addDays(1)->addHours(2),
                'warna' => '#3498db',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan SDM',
                'deskripsi' => 'Pelatihan peningkatan kapasitas SDM',
                'tempat' => 'Ruang Rapat Utama',
                'tanggal_mulai' => Carbon::now()->addDays(3),
                'tanggal_selesai' => Carbon::now()->addDays(5),
                'warna' => '#2ecc71',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kunjungan Kerja',
                'deskripsi' => 'Kunjungan kerja ke instansi terkait',
                'tempat' => 'Kantor Dinas Terkait',
                'tanggal_mulai' => Carbon::now()->addDays(7),
                'tanggal_selesai' => Carbon::now()->addDays(7)->addHours(4),
                'warna' => '#e74c3c',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Sosialisasi Program',
                'deskripsi' => 'Sosialisasi program baru kepada masyarakat',
                'tempat' => 'Aula Desa',
                'tanggal_mulai' => Carbon::now()->addDays(10),
                'tanggal_selesai' => Carbon::now()->addDays(10)->addHours(3),
                'warna' => '#9b59b6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Evaluasi Triwulan',
                'deskripsi' => 'Evaluasi capaian triwulan berjalan',
                'tempat' => 'Ruang Rapat Lt. 2',
                'tanggal_mulai' => Carbon::now()->addDays(14),
                'tanggal_selesai' => Carbon::now()->addDays(14)->addHours(5),
                'warna' => '#f39c12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AgendaKegiatan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create agenda kegiatan
        foreach ($agendaKegiatanData as $data) {
            // Create the agenda item if it doesn't exist
            AgendaKegiatan::firstOrCreate(
                [
                    'judul' => $data['judul'],
                    'tanggal_mulai' => $data['tanggal_mulai']
                ],
                $data
            );
        }
        
        $this->command->info('Berhasil menambahkan ' . count($agendaKegiatanData) . ' data agenda kegiatan.');
    }
}
