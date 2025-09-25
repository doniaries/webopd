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
            ShieldSeeder::class,   // Set up roles and permissions using Filament Shield
            UserSeeder::class,     // Then create users
            // Other seeders
            UnitKerjaSeeder::class,
            VisiMisiSeeder::class,
            SambutanPimpinanSeeder::class,
            PengaturanSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            BannerSeeder::class,
            // SliderSeeder::class,
            // ProdukHukumSeeder::class,
            InfografisSeeder::class,
            AgendaKegiatanSeeder::class,
            PengumumanSeeder::class,
            DokumenSeeder::class,
            ExternalLinkSeeder::class,
        ]);
    }
}
