<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run()
    {
        $teamId = Team::first()->id;
        
        $unitKerjas = [
            [
                'nama_unit' => 'Bidang Sekretariat',
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
                [
                    'team_id' => $teamId,
                    'slug' => $unit['slug']
                ]
            );
        }
    }
}
