<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Team::all()->each(function ($team) {
            \App\Models\Informasi::factory(4)->create([
                'team_id' => $team->id,
            ]);
        });
    }
}
