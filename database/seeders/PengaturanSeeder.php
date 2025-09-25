<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Pengaturan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create default settings
        $settings = [
            'name' => 'Dinas Komunikasi dan Informatika',
            'slug' => 'dinas-komunikasi-dan-informatika',
            'logo' => null, // Akan diisi melalui admin
            'favicon' => null, // Akan diisi melalui admin
            'kepala_instansi' => 'Kepala Dinas',
            'alamat_instansi' => 'Gedung Bersama',
            'no_telp_instansi' => '021-12345678',
            'email_instansi' => 'info@example.com',
            'facebook' => 'https://facebook.com',
            'twitter' => 'https://twitter.com',
            'instagram' => 'https://instagram.com',
            'youtube' => 'https://youtube.com',
        ];

        // Create the settings record
        \App\Models\Pengaturan::create($settings);

        $this->command->info('Successfully created settings!');
    }
}
