<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UnitKerjaSeeder extends Seeder
{
    public function run()
    {
        $unitKerjas = [
            [
                'nama_unit' => 'Bidang Sekretariat',
                'slug' => Str::slug('Bidang Sekretariat'),
                'slug' => 'bidang-sekretariat',
            ],
            [
                'nama_unit' => 'Bidang PIKP',
                'slug' => 'bidang-pikp',
            ],
            [
                'nama_unit' => 'Bidang TI',
                'slug' => 'bidang-ti',
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
