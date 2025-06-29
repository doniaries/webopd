<?php

// database/seeders/ExternalLinkSeeder.php
namespace Database\Seeders;

use App\Models\ExternalLink;
use Illuminate\Database\Seeder;

class ExternalLinkSeeder extends Seeder
{
    public function run()
    {
        $links = [
            [
                'nama' => 'Sistem Informasi Kepegawaian',
                'url' => 'https://sipkd.sijunjung.go.id',
                'icon' => 'fas fa-users',
                'deskripsi' => 'Akses sistem informasi kepegawaian daerah',
                'status' => 'aktif',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'E-Planning',
                'url' => 'https://eplanning.sijunjung.go.id',
                'icon' => 'fas fa-project-diagram',
                'deskripsi' => 'Sistem perencanaan pembangunan daerah',
                'status' => 'aktif',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'E-Budgeting',
                'url' => 'https://ebudgeting.sijunjung.go.id',
                'icon' => 'fas fa-money-bill-wave',
                'deskripsi' => 'Sistem penganggaran berbasis elektronik',
                'status' => 'aktif',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Informasi Kependudukan',
                'url' => 'https://dukcapil.sijunjung.go.id',
                'icon' => 'fas fa-id-card',
                'deskripsi' => 'Layanan administrasi kependudukan online',
                'status' => 'aktif',
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Informasi Pengadaan',
                'url' => 'https://lpse.sijunjung.go.id',
                'icon' => 'fas fa-shopping-cart',
                'deskripsi' => 'Layanan pengadaan barang/jasa pemerintah',
                'status' => 'aktif',
                'urutan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'E-Surat',
                'url' => 'https://surat.sijunjung.go.id',
                'icon' => 'fas fa-envelope',
                'deskripsi' => 'Sistem surat menyurat elektronik',
                'status' => 'aktif',
                'urutan' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Informasi Kinerja Pegawai',
                'url' => 'https://sikp.sijunjung.go.id',
                'icon' => 'fas fa-chart-line',
                'deskripsi' => 'Monitoring dan evaluasi kinerja pegawai',
                'status' => 'aktif',
                'urutan' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Informasi Aset Daerah',
                'url' => 'https://siad.sijunjung.go.id',
                'icon' => 'fas fa-building',
                'deskripsi' => 'Manajemen aset daerah',
                'status' => 'aktif',
                'urutan' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Informasi Keuangan Daerah',
                'url' => 'https://sikd.sijunjung.go.id',
                'icon' => 'fas fa-wallet',
                'deskripsi' => 'Manajemen keuangan daerah',
                'status' => 'aktif',
                'urutan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($links as $link) {
            ExternalLink::firstOrCreate(
                ['url' => $link['url']],
                $link
            );
        }

        $this->command->info('External links seeded successfully!');
    }
}
