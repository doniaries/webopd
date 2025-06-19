<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // Get all teams or create a default team if none exists
        $teams = Team::all();

        if ($teams->isEmpty()) {
            $team = Team::create([
                'name' => 'Default Team',
                'slug' => 'default-team',
                'singkatan' => 'DT',
                'alamat' => 'Alamat default',
                'email_organisasi' => 'default@example.com'
            ]);
            $teams = collect([$team]);
        }

        // Create some sample tags with different colors
        $tags = [
            ['name' => 'Penting'],
            ['name' => 'Informasi'],
            ['name' => 'Update'],
            ['name' => 'Peringatan'],
            ['name' => 'Pengumuman'],
        ];

        foreach ($teams as $team) {
            foreach ($tags as $tag) {
                // Create tag for the team
                Tag::firstOrCreate(
                    [
                        'team_id' => $team->id,
                        'slug' => Str::slug($tag['name'])
                    ],
                    [
                        'name' => $tag['name'],
                    ]
                );
            }
        }
    }
}
