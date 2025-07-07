<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $pengumuman = [
            [
                'judul' => 'Pendaftaran Diklat Peningkatan Kompetensi ASN 2025',
                'slug' => 'pendaftaran-diklat-peningkatan-kompetensi-asn-2025',
                'isi' => 'Diberitahukan kepada seluruh ASN untuk mengikuti pendaftaran Diklat Peningkatan Kompetensi Tahun 2025. Pendaftaran dibuka mulai tanggal 1 Juli - 15 Juli 2025.',
                'views' => 10,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Penerimaan CPNS Kementerian XYZ Tahun 2025',
                'slug' => 'penerimaan-cpns-kementerian-xyz-2025',
                'isi' => 'Dibuka pendaftaran CPNS Kementerian XYZ Tahun 2025. Persyaratan dan tata cara pendaftaran dapat diunduh pada link terlampir.',
                'file' => 'pengumuman/cpns-2025.pdf',
                'views' => 30,
                'published_at' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Jadwal Pelaksanaan Ujian Dinas Tingkat II',
                'slug' => 'jadwal-ujian-dinas-tingkat-ii',
                'isi' => 'Berikut jadwal pelaksanaan Ujian Dinas Tingkat II yang akan dilaksanakan pada tanggal 20 Juli 2025. Peserta diharapkan hadir 30 menit sebelum ujian dimulai.',
                'views' => 12,
                'published_at' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pembukaan Pendaftaran Beasiswa Pendidikan S2',
                'slug' => 'beasiswa-pendidikan-s2-2025',
                'isi' => 'Dibuka pendaftaran beasiswa pendidikan S2 untuk pegawai negeri sipil. Batas pendaftaran sampai dengan 30 Agustus 2025.',
                'file' => 'pengumuman/beasiswa-s2-2025.pdf',
                'views' => 20,
                'published_at' => now()->subWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Perubahan Jam Kerja Selama Bulan Ramadhan',
                'slug' => 'perubahan-jam-kerja-ramadhan-1446H',
                'isi' => 'Diberitahukan bahwa mulai besok akan diberlakukan perubahan jam kerja selama bulan Ramadhan 1446 H menjadi pukul 08.00 - 14.00 WIB.',
                'views' => 15,
                'published_at' => now()->subDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($pengumuman as $data) {
            Pengumuman::create($data);
        }
    }
}
