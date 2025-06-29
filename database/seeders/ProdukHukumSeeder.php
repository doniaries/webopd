<?php

namespace Database\Seeders;

use App\Models\KategoriProdukHukum;
use App\Models\ProdukHukum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukHukumSeeder extends Seeder
{
    public function run()
    {
        // Get or create categories
        $kategoriPeraturan = KategoriProdukHukum::firstOrCreate(
            ['nama' => 'Peraturan Daerah'],
            [
                'slug' => Str::slug('Peraturan Daerah'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $kategoriPerbup = KategoriProdukHukum::firstOrCreate(
            ['nama' => 'Peraturan Bupati'],
            [
                'slug' => Str::slug('Peraturan Bupati'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $kategoriKeputusan = KategoriProdukHukum::firstOrCreate(
            ['nama' => 'Keputusan Bupati'],
            [
                'slug' => Str::slug('Keputusan Bupati'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Sample legal products
        $produkHukumData = [
            [
                'nomor' => '1',
                'tahun' => '2023',
                'tentang' => 'Perubahan atas Peraturan Daerah Nomor 5 Tahun 2020 tentang Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Sijunjung Tahun 2021-2026',
                'kategori_id' => $kategoriPeraturan->id,
                'file' => 'perda-1-tahun-2023.pdf',
                'tanggal_ditetapkan' => '2023-01-15',
                'tanggal_diundangkan' => '2023-01-16',
                'status' => 'berlaku',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor' => '2',
                'tahun' => '2023',
                'tentang' => 'Perubahan Kedua atas Peraturan Daerah Nomor 3 Tahun 2020 tentang Rencana Tata Ruang Wilayah (RTRW) Kabupaten Sijunjung Tahun 2020-2040',
                'kategori_id' => $kategoriPeraturan->id,
                'file' => 'perda-2-tahun-2023.pdf',
                'tanggal_ditetapkan' => '2023-02-20',
                'tanggal_diundangkan' => '2023-02-21',
                'status' => 'berlaku',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Create legal products
        foreach ($produkHukumData as $data) {
            $slug = Str::slug($data['tentang']);
            
            // Check if a product with the same slug already exists
            $exists = ProdukHukum::where('slug', $slug)->exists();

            if (!$exists) {
                ProdukHukum::create(array_merge($data, ['slug' => $slug]));
            }
        }
    }
}
