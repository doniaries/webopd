<?php

namespace Database\Seeders;

use App\Models\AgendaKegiatan;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AgendaKegiatanSeeder extends Seeder
{
    public function run()
    {
        // Get all teams
        $teams = Team::all();
        
        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        // Base data for agenda kegiatan
        $now = Carbon::now();
        
        // Helper function to create agenda items with proper time fields
        $createAgenda = function($name, $desc, $place, $startDate, $endDate, $startTime, $endTime, $org = null) {
            return [
                'nama_agenda' => $name,
                'uraian_agenda' => $desc,
                'tempat' => $place,
                'dari_tanggal' => $startDate->format('Y-m-d'),
                'sampai_tanggal' => $endDate->format('Y-m-d'),
                'waktu_mulai' => $startTime->format('H:i:s'),
                'waktu_selesai' => $endTime->format('H:i:s'),
                'penyelenggara' => $org
            ];
        };
        
        // Agenda yang sudah selesai (bulan lalu)
        $agendaSelesai = [
            $createAgenda(
                'Rapat Evaluasi Triwulan I',
                'Evaluasi capaian kinerja triwulan I tahun ' . $now->year . ' dan penyusunan rencana triwulan II.',
                'Ruang Rapat Lantai 3',
                $now->copy()->subMonth()->startOfMonth()->addDays(5),
                $now->copy()->subMonth()->startOfMonth()->addDays(5),
                $now->copy()->setTime(9, 0),
                $now->copy()->setTime(12, 0),
                'Badan Perencanaan Pembangunan Daerah'
            ),
            $createAgenda(
                'Workshop Penyusunan RKPD',
                'Workshop penyusunan Rencana Kerja Pemerintah Daerah tahun ' . ($now->year + 1) . '.',
                'Aula Kantor Bupati',
                $now->copy()->subMonth()->startOfMonth()->addDays(10),
                $now->copy()->subMonth()->startOfMonth()->addDays(12),
                $now->copy()->setTime(8, 0),
                $now->copy()->setTime(16, 0),
                'Sekretariat Daerah'
            )
        ];

        // Agenda yang sedang berlangsung (hari ini)
        $agendaBerjalan = [
            $createAgenda(
                'Rapat Koordinasi Bulanan',
                'Rapat koordinasi bulanan untuk sinkronisasi program dan kegiatan antar OPD.',
                'Ruang Rapat Lantai 2',
                $now,
                $now,
                $now->copy()->setTime(10, 0),
                $now->copy()->setTime(12, 0),
                'Bagian Organisasi'
            )
        ];

        // Agenda yang akan datang (bulan ini dan depan)
        $agendaAkanDatang = [
            $createAgenda(
                'Pelatihan Manajemen Keuangan Daerah',
                'Pelatihan ini bertujuan untuk meningkatkan kompetensi SDM di bidang pengelolaan keuangan daerah.',
                'Aula Kantor Bupati',
                $now->copy()->addDays(3),
                $now->copy()->addDays(5),
                $now->copy()->setTime(8, 0),
                $now->copy()->setTime(17, 0),
                'Badan Keuangan Daerah'
            ),
            $createAgenda(
                'Rakor Pimpinan',
                'Rapat koordinasi pimpinan untuk mengevaluasi capaian kinerja dan menyusun rencana kerja ke depan.',
                'Ruang Rapat Lantai 3',
                $now->copy()->addWeek(),
                $now->copy()->addWeek(),
                $now->copy()->setTime(9, 0),
                $now->copy()->setTime(12, 0),
                'Sekretariat Daerah'
            ),
            $createAgenda(
                'Kunjungan Kerja ke Kecamatan Terpencil',
                'Kunjungan kerja ke kecamatan terpencil untuk mengevaluasi pelaksanaan program pembangunan.',
                'Kecamatan Terpencil',
                $now->copy()->addWeeks(2),
                $now->copy()->addWeeks(2)->addDays(2),
                $now->copy()->setTime(8, 0),
                $now->copy()->setTime(15, 0),
                'Badan Perencanaan Pembangunan Daerah'
            ),
            $createAgenda(
                'Seminar Nasional Pembangunan Daerah',
                'Seminar nasional dengan tema "Inovasi dan Kolaborasi dalam Mewujudkan Pembangunan Berkelanjutan".',
                'Hotel Grand Ballroom',
                $now->copy()->addMonth()->startOfMonth()->addDays(5),
                $now->copy()->addMonth()->startOfMonth()->addDays(6),
                $now->copy()->setTime(8, 0),
                $now->copy()->setTime(17, 0),
                'Badan Perencanaan Pembangunan Daerah'
            )
        ];

        // Gabungkan semua agenda
        $agendaKegiatanData = array_merge($agendaSelesai, $agendaBerjalan, $agendaAkanDatang);

        // Hapus data agenda yang mungkin sudah ada
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AgendaKegiatan::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create agenda kegiatan for each team
        foreach ($teams as $team) {
            foreach ($agendaKegiatanData as $data) {
                // Ensure all required fields are present
                $agendaData = array_merge([
                    'team_id' => $team->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ], $data);

                // Create the agenda item
                AgendaKegiatan::create($agendaData);
            }
        }
        
        $this->command->info('Berhasil menambahkan ' . count($agendaKegiatanData) * count($teams) . ' data agenda kegiatan.');

    }
}
