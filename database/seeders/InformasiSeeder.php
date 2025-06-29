<?php

namespace Database\Seeders;

use App\Models\Informasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $informasiData = [
            [
                'judul' => 'Peningkatan Layanan Publik Digital', 
                'isi' => 'Dinas Komunikasi dan Informatika (Diskominfo) meluncurkan program peningkatan layanan publik berbasis digital untuk memudahkan akses masyarakat terhadap informasi dan layanan pemerintah. Inisiatif ini mencakup pengembangan aplikasi mobile dan portal web interaktif.',
                'file' => 'https://example.com/file1.pdf',
            ],
            [
                'judul' => 'Sosialisasi Keamanan Siber untuk UMKM', 
                'isi' => 'Diskominfo mengadakan sosialisasi keamanan siber bagi pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) di wilayah ini. Tujuannya adalah untuk meningkatkan kesadaran dan kapasitas UMKM dalam menghadapi ancaman siber yang semakin kompleks.',
                'file' => 'https://example.com/file2.pdf',
            ],
            [
                'judul' => 'Pelatihan Literasi Digital bagi Masyarakat', 
                'isi' => 'Dalam upaya meningkatkan literasi digital masyarakat, Diskominfo menyelenggarakan serangkaian pelatihan gratis. Materi pelatihan meliputi penggunaan internet sehat, pencegahan hoaks, dan pemanfaatan media sosial secara bijak.',
                'file' => 'https://example.com/file3.pdf',
            ],
            [
                'judul' => 'Pengembangan Infrastruktur Jaringan Internet', 
                'isi' => 'Pemerintah daerah melalui Diskominfo terus berupaya memperluas jangkauan dan meningkatkan kualitas infrastruktur jaringan internet di seluruh pelosok daerah. Hal ini diharapkan dapat mendukung pemerataan akses informasi dan ekonomi digital.',
                'file' => 'https://example.com/file4.pdf',
            ],
        ];

        foreach ($informasiData as $data) {
            Informasi::firstOrCreate(
                ['judul' => $data['judul']],
                array_merge($data, [
                    'published_at' => now(),
                    'slug' => \Illuminate\Support\Str::slug($data['judul']),
                ])
            );
        }
    }
}
