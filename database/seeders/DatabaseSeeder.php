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
            ShieldSeeder::class,  // Must come before UserSeeder
            UserSeeder::class,
            UnitKerjaSeeder::class,
            VisiMisiSeeder::class,
            SambutanPimpinanSeeder::class,
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
            ExternalLinkSeeder::class,
        ]);
    }
}
