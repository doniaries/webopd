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
            'nama_website' => 'Website Pemerintah',
            'logo_instansi' => 'assets/img/logo.png',
            'favicon_instansi' => 'assets/img/favicon.png',
            'kepala_instansi' => 'Dr. John Doe, M.Si',
            'alamat_instansi' => 'Jl. Lintas Sumatra No. 1, Muaro Sijunjung, Sumatera Barat',
            'no_telp_instansi' => '(0754) 12345',
            'email_instansi' => 'info@sijunjung.go.id',
            'facebook' => 'https://facebook.com/pemkabsijunjung',
            'twitter' => 'https://twitter.com/pemkabsijunjung',
            'instagram' => 'https://instagram.com/pemkabsijunjung',
            'youtube' => 'https://youtube.com/c/pemkabsijunjung',
        ];

        // Create the settings record
        Pengaturan::create($settings);

        $this->command->info('Successfully created settings!');
    }
}
