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

        // Sample agenda kegiatan data
        $agendaKegiatanData = [
            [
                'nama_agenda' => 'Rapat Koordinasi',
                'slug' => Str::slug('Rapat Koordinasi'),
                'uraian_agenda' => 'Rapat koordinasi bulanan',
                'tempat' => 'Aula Kantor',
                'penyelenggara' => 'Badan Perencanaan Pembangunan Daerah',
                'dari_tanggal' => Carbon::now()->addDays(1),
                'sampai_tanggal' => Carbon::now()->addDays(1),
                'waktu_mulai' => '09:00:00',
                'waktu_selesai' => '11:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Pelatihan SDM',
                'slug' => Str::slug('Pelatihan SDM'),
                'uraian_agenda' => 'Pelatihan peningkatan kapasitas SDM',
                'tempat' => 'Ruang Rapat Utama',
                'penyelenggara' => 'Dinas Sumber Daya Manusia',
                'dari_tanggal' => Carbon::now()->addDays(3),
                'sampai_tanggal' => Carbon::now()->addDays(5),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Kunjungan Kerja',
                'slug' => Str::slug('Kunjungan Kerja'),
                'uraian_agenda' => 'Kunjungan kerja ke instansi terkait',
                'tempat' => 'Kantor Dinas Terkait',
                'penyelenggara' => 'Sekretariat Daerah',
                'dari_tanggal' => Carbon::now()->addDays(7),
                'sampai_tanggal' => Carbon::now()->addDays(7),
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Sosialisasi Program',
                'slug' => Str::slug('Sosialisasi Program'),
                'uraian_agenda' => 'Sosialisasi program baru kepada masyarakat',
                'tempat' => 'Aula Desa',
                'penyelenggara' => 'Dinas Pemberdayaan Masyarakat',
                'dari_tanggal' => Carbon::now()->addDays(10),
                'sampai_tanggal' => Carbon::now()->addDays(10),
                'waktu_mulai' => '13:00:00',
                'waktu_selesai' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_agenda' => 'Rapat Evaluasi',
                'slug' => Str::slug('Rapat Evaluasi'),
                'uraian_agenda' => 'Evaluasi program triwulanan',
                'tempat' => 'Ruang Rapat 1',
                'penyelenggara' => 'Badan Perencanaan Pembangunan Daerah',
                'dari_tanggal' => Carbon::now()->addDays(14),
                'sampai_tanggal' => Carbon::now()->addDays(14),
                'waktu_mulai' => '14:00:00',
                'waktu_selesai' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
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
