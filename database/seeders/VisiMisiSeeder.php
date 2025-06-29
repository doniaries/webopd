<?php

namespace Database\Seeders;

use App\Models\VisiMisi;
use Illuminate\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    public function run()
    {
        // Sample vision and mission data
        $visionMissionData = [
            'visi' => 'Menjadi pusat informasi dan komunikasi terdepan yang mendukung terwujudnya pemerintahan yang transparan dan akuntabel',
            'misi' => json_encode([
                'Menyediakan layanan informasi yang akurat dan terpercaya',
                'Mengembangkan sistem informasi yang terintegrasi',
                'Meningkatkan kualitas pelayanan publik melalui teknologi informasi',
                'Mendorong partisipasi masyarakat dalam pembangunan daerah',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Create vision and mission
        VisiMisi::firstOrCreate(
            ['visi' => $visionMissionData['visi']],
            $visionMissionData
        );
    }
}
