<?php

namespace Database\Seeders;

use App\Models\ExternalLink;
use Illuminate\Database\Seeder;

class ExternalLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            [
                'nama_link' => 'Dinas Koperasi dan UKM',
                'url' => 'https://kukm.kemendag.go.id/',
                'logo' => 'https://via.placeholder.com/100',
            ],
            [
                'nama_link' => 'Kementerian Koperasi dan UKM',
                'url' => 'https://kemenkopukm.go.id/',
                'logo' => 'https://via.placeholder.com/100',
            ],
            [
                'nama_link' => 'Layanan Perizinan Berusaha',
                'url' => 'https://oss.go.id/',
                'logo' => 'https://via.placeholder.com/100',
            ],
            [
                'nama_link' => 'BPJS Ketenagakerjaan',
                'url' => 'https://www.bpjsketenagakerjaan.go.id/',
                'logo' => 'https://via.placeholder.com/100',
            ],
            [
                'nama_link' => 'BPJS Kesehatan',
                'url' => 'https://www.bpjs-kesehatan.go.id/',
                'logo' => 'https://via.placeholder.com/100',
            ],
            [
                'nama_link' => 'Dinas Tenaga Kerja',
                'url' => 'https://disnaker.kemnaker.go.id/',
                'logo' => 'https://via.placeholder.com/100',
            ],
        ];

        foreach ($links as $link) {
            ExternalLink::updateOrCreate(
                ['url' => $link['url']],
                $link
            );
        }
    }
}
