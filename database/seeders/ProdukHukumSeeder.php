<?php

namespace Database\Seeders;

use App\Models\ProdukHukum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukHukumSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProdukHukum::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create sample produk hukum
        $produkHukums = [
            [
                'judul' => 'Peraturan Daerah Nomor 1 Tahun 2023',
                'slug' => Str::slug('Peraturan Daerah Nomor 1 Tahun 2023'),
                'uraian' => 'Tentang Penyelenggaraan Pemerintahan Daerah',
                'file' => 'perda-1-2023.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Peraturan Bupati Nomor 2 Tahun 2023',
                'slug' => Str::slug('Peraturan Bupati Nomor 2 Tahun 2023'),
                'uraian' => 'Tentang Tata Cara Pengelolaan Keuangan Daerah',
                'file' => 'perbup-2-2023.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Peraturan Walikota Nomor 3 Tahun 2023',
                'slug' => Str::slug('Peraturan Walikota Nomor 3 Tahun 2023'),
                'uraian' => 'Tentang Penataan Ruang Wilayah Kota',
                'file' => 'perwal-3-2023.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert produk hukum
        foreach ($produkHukums as $produkHukum) {
            ProdukHukum::firstOrCreate(
                ['judul' => $produkHukum['judul']],
                $produkHukum
            );
        }
    }
}
