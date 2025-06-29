<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        // Base settings data
        $settings = [
            [
                'key' => 'nama_aplikasi',
                'value' => 'Sistem Informasi Pemerintahan',
                'keterangan' => 'Nama aplikasi yang ditampilkan di header',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nama_instansi',
                'value' => 'Pemerintah Kabupaten Sijunjung',
                'keterangan' => 'Nama instansi pemilik aplikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'alamat_instansi',
                'value' => 'Jl. Lintas Sumatra No. 1, Muaro Sijunjung, Sumatera Barat',
                'keterangan' => 'Alamat lengkap instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'telepon_instansi',
                'value' => '(0754) 12345',
                'keterangan' => 'Nomor telepon instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'email_instansi',
                'value' => 'info@sijunjung.go.id',
                'keterangan' => 'Alamat email resmi instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'website_instansi',
                'value' => 'https://sijunjung.go.id',
                'keterangan' => 'Website resmi instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_instansi',
                'value' => 'logo.png',
                'keterangan' => 'Logo instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'favicon',
                'value' => 'favicon.ico',
                'keterangan' => 'Favicon website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_text',
                'value' => ' ' . date('Y') . ' Pemerintah Kabupaten Sijunjung. Semua Hak Dilindungi.',
                'keterangan' => 'Teks yang ditampilkan di footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Create settings if they don't exist
        foreach ($settings as $setting) {
            Pengaturan::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Successfully created settings!');
    }
}
