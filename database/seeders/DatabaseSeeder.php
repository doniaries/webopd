<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in order
        $this->call([
            UserSeeder::class,
            UnitKerjaSeeder::class,
            VisiMisiSeeder::class,
            SambutanPimpinanSeeder::class,
            ShieldSeeder::class,
            PengaturanSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            BannerSeeder::class,
            SliderSeeder::class,
            InformasiSeeder::class,
            ProdukHukumSeeder::class,
            InfografisSeeder::class,
            AgendaKegiatanSeeder::class,
            DokumenSeeder::class,
            SambutanPimpinanSeeder::class,
            ExternalLinkSeeder::class,
        ]);
    }
}
