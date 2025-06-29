<?php

namespace Database\Seeders;

use App\Models\SambutanPimpinan;
use Illuminate\Database\Seeder;

class SambutanPimpinanSeeder extends Seeder
{
    public function run()
    {
        // Sample welcome message
        $welcomeMessage = [
            'judul' => 'Sambutan Kepala Dinas',
            'slug' => 'sambutan-kepala-dinas',
            'isi_sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh, Selamat datang di website resmi kami. Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat.',
            'foto' => 'image/placeholder.jpg',
            'nama' => 'Dr. John Doe, M.Si',
            'jabatan' => 'Kepala Dinas Komunikasi dan Informatika',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Create welcome message if it doesn't exist
        if (!SambutanPimpinan::exists()) {
            SambutanPimpinan::create($welcomeMessage);
        }
    }
}
