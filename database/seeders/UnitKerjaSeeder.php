<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run()
    {
        $unitKerjas = [
            [
                'nama_unit' => 'Bidang Sekretariat',
                'slug' => 'bidang-sekretariat',
                'deskripsi' => 'Bertanggung jawab atas administrasi dan tata kelola organisasi',
            ],
            [
                'nama_unit' => 'Bidang PIKP',
                'slug' => 'bidang-pikp',
                'deskripsi' => 'Bertanggung jawab atas pengelolaan informasi dan komunikasi publik',
            ],
            [
                'nama_unit' => 'Bidang TI',
                'slug' => 'bidang-ti',
                'deskripsi' => 'Bertanggung jawab atas pengembangan dan pemeliharaan teknologi informasi',
            ],
        ];

        foreach ($unitKerjas as $unit) {
            UnitKerja::firstOrCreate(
                ['nama_unit' => $unit['nama_unit']],
                $unit
            );
        }
    }
}
