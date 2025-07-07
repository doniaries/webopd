<?php

namespace Database\Seeders;

use App\Models\AgendaKegiatan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgendaKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AgendaKegiatan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Sample agenda kegiatan data for next 3 months (3 events per month)
        $agendaKegiatanData = [
            // Month 1
            [
                'nama_agenda' => 'Rapat Koordinasi Bulanan',
                'slug' => Str::slug('Rapat Koordinasi Bulanan'),
                'uraian_agenda' => 'Rapat koordinasi bulanan antar dinas',
                'tempat' => 'Aula Kantor Bappeda',
                'penyelenggara' => 'Badan Perencanaan Pembangunan Daerah',
                'dari_tanggal' => Carbon::now()->subDays(2),
                'sampai_tanggal' => Carbon::now()->subDays(2),
                'waktu_mulai' => '09:00:00',
                'waktu_selesai' => '12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Pelatihan Pengembangan SDM',
                'slug' => Str::slug('Pelatihan Pengembangan SDM'),
                'uraian_agenda' => 'Pelatihan peningkatan kapasitas SDM Aparatur',
                'tempat' => 'Gedung Serba Guna',
                'penyelenggara' => 'Badan Kepegawaian Daerah',
                'dari_tanggal' => Carbon::now()->addDays(5),
                'sampai_tanggal' => Carbon::now()->addDays(8),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Monitoring dan Evaluasi Program',
                'slug' => Str::slug('Monitoring dan Evaluasi Program'),
                'uraian_agenda' => 'Kegiatan monitoring dan evaluasi program pembangunan',
                'tempat' => 'Dinas Pekerjaan Umum',
                'penyelenggara' => 'Bappeda',
                'dari_tanggal' => Carbon::now()->addDays(15),
                'sampai_tanggal' => Carbon::now()->addDays(15),
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '15:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Month 2
            [
                'nama_agenda' => 'Workshop Penyusunan RKPD',
                'slug' => Str::slug('Workshop Penyusunan RKPD'),
                'uraian_agenda' => 'Workshop penyusunan Rencana Kerja Pemerintah Daerah',
                'tempat' => 'Hotel Grand Mercure',
                'penyelenggara' => 'Bappeda',
                'dari_tanggal' => Carbon::now()->addMonth()->startOfMonth()->addDays(3),
                'sampai_tanggal' => Carbon::now()->addMonth()->startOfMonth()->addDays(5),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Rapat Koordinasi SKPD',
                'slug' => Str::slug('Rapat Koordinasi SKPD'),
                'uraian_agenda' => 'Koordinasi antar Satuan Kerja Perangkat Daerah',
                'tempat' => 'Ruang Rapat Lantai 3',
                'penyelenggara' => 'Sekretariat Daerah',
                'dari_tanggal' => Carbon::now()->addMonth()->startOfMonth()->addDays(12),
                'sampai_tanggal' => Carbon::now()->addMonth()->startOfMonth()->addDays(12),
                'waktu_mulai' => '13:00:00',
                'waktu_selesai' => '15:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Sosialisasi APBD',
                'slug' => Str::slug('Sosialisasi APBD'),
                'uraian_agenda' => 'Sosialisasi Anggaran Pendapatan dan Belanja Daerah',
                'tempat' => 'Aula Kantor Bupati',
                'penyelenggara' => 'Badan Pengelola Keuangan Daerah',
                'dari_tanggal' => Carbon::now()->addMonth()->endOfMonth()->subDays(5),
                'sampai_tanggal' => Carbon::now()->addMonth()->endOfMonth()->subDays(5),
                'waktu_mulai' => '09:30:00',
                'waktu_selesai' => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Month 3
            [
                'nama_agenda' => 'Rapat Paripurna DPRD',
                'slug' => Str::slug('Rapat Paripurna DPRD'),
                'uraian_agenda' => 'Rapat paripurna DPRD membahas laporan keterangan pertanggungjawaban',
                'tempat' => 'Gedung DPRD',
                'penyelenggara' => 'DPRD',
                'dari_tanggal' => Carbon::now()->addMonths(2)->startOfMonth()->addDays(2),
                'sampai_tanggal' => Carbon::now()->addMonths(2)->startOfMonth()->addDays(2),
                'waktu_mulai' => '09:00:00',
                'waktu_selesai' => '15:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Pelatihan Aplikasi E-Government',
                'slug' => Str::slug('Pelatihan Aplikasi E-Government'),
                'uraian_agenda' => 'Pelatihan penggunaan aplikasi e-government untuk ASN',
                'tempat' => 'Lab Komputer Dinas Kominfo',
                'penyelenggara' => 'Dinas Komunikasi dan Informatika',
                'dari_tanggal' => Carbon::now()->addMonths(2)->startOfMonth()->addDays(10),
                'sampai_tanggal' => Carbon::now()->addMonths(2)->startOfMonth()->addDays(12),
                'waktu_mulai' => '08:30:00',
                'waktu_selesai' => '16:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Kunjungan Kerja Bupati',
                'slug' => Str::slug('Kunjungan Kerja Bupati'),
                'uraian_agenda' => 'Kunjungan kerja Bupati ke desa-desa binaan',
                'tempat' => 'Beberapa Lokasi Desa',
                'penyelenggara' => 'Sekretariat Daerah',
                'dari_tanggal' => Carbon::now()->addMonths(2)->endOfMonth()->subDays(3),
                'sampai_tanggal' => Carbon::now()->addMonths(2)->endOfMonth()->subDays(1),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert agenda kegiatan
        foreach ($agendaKegiatanData as $agenda) {
            AgendaKegiatan::firstOrCreate(
                ['nama_agenda' => $agenda['nama_agenda'], 'dari_tanggal' => $agenda['dari_tanggal']],
                $agenda
            );
        }

        $this->command->info('Berhasil menambahkan ' . count($agendaKegiatanData) . ' data agenda kegiatan.');
    }
}
