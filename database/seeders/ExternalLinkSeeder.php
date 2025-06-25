<?php

// database/seeders/ExternalLinkSeeder.php
namespace Database\Seeders;

use App\Models\ExternalLink;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ExternalLinkSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada minimal satu team
        $team = Team::first();

        if (!$team) {
            $team = Team::create([
                'name' => 'Pemerintah Pusat',
                'slug' => 'pemerintah-pusat',
                'description' => 'Lembaga Pemerintah Pusat'
            ]);
        }

        $links = [
            [
                'name' => 'Kementerian Dalam Negeri',
                'url' => 'https://www.kemendagri.go.id/',
                'icon' => 'fa-building-columns',
                'team_id' => $team->id,
            ],
            [
                'name' => 'Kementerian Kesehatan',
                'url' => 'https://www.kemkes.go.id/',
                'icon' => 'fa-hospital',
                'team_id' => $team->id,
            ],
            [
                'name' => 'Kementerian Pendidikan',
                'url' => 'https://www.kemdikbud.go.id/',
                'icon' => null, // Tidak ada icon
                'team_id' => $team->id,
            ],
            [
                'name' => 'BPJS Kesehatan',
                'url' => 'https://www.bpjsketenagakerjaan.go.id/',
                'icon' => 'fa-heart-pulse',
                'team_id' => $team->id,
            ],
            [
                'name' => 'Badan Pusat Statistik',
                'url' => 'https://www.bps.go.id/',
                'icon' => null, // Tidak ada icon
                'team_id' => $team->id,
            ],
            [
                'name' => 'Kementerian Keuangan',
                'url' => 'https://www.kemenkeu.go.id/',
                'icon' => null, // Tidak ada icon
                'team_id' => $team->id,
            ],
            [
                'name' => 'BPN RI',
                'url' => 'https://www.atrbpn.go.id/',
                'icon' => 'fa-landmark',
                'team_id' => $team->id,
            ],
            [
                'name' => 'Kemenkumham',
                'url' => 'https://www.kemenkumham.go.id/',
                'icon' => 'fa-scale-balanced',
                'team_id' => $team->id,
            ],
            [
                'name' => 'Kemenkeu RI',
                'url' => 'https://www.kemenkeu.go.id/',
                'icon' => 'fa-sack-dollar',
                'team_id' => $team->id,
            ],
            [
                'name' => 'BKN',
                'url' => 'https://www.bkn.go.id/',
                'icon' => 'fa-users',
                'team_id' => $team->id,
            ],
        ];

        foreach ($links as $link) {
            ExternalLink::updateOrCreate(
                ['url' => $link['url']],
                $link
            );
        }

        $this->command->info('External links seeded successfully!');
    }
}
