<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run()
    {

        $teams = Team::all();
        $unitKerjas = [
            [
                'team_id' => $teams->first()->id,
                'nama_unit' => 'Bidang Sekretariat',
                'slug' => 'bidang-sekretariat',
            ],
            [
                'team_id' => $teams->first()->id,
                'nama_unit' => 'Bidang PIKP',
                'slug' => 'bidang-pikp',
            ],
            [
                'team_id' => $teams->first()->id,
                'nama_unit' => 'Bidang TI',
                'slug' => 'bidang-ti',
            ],
        ];

        foreach ($unitKerjas as $unit) {
            UnitKerja::create($unit);
        }
    }
}
