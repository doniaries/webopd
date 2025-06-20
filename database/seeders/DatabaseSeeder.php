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
        $this->call([
            TeamSeeder::class,
            ShieldSeeder::class,
            UserSeeder::class,
            UnitKerjaSeeder::class,
            PengaturanSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            BannerSeeder::class,
            SliderSeeder::class,
            InformasiSeeder::class,
            VisiMisiSeeder::class,
            ProdukHukumSeeder::class,
            InfografisSeeder::class,
            AgendaKegiatanSeeder::class,
            DokumenSeeder::class,
            SambutanPimpinanSeeder::class,
        ]);
    }
}
