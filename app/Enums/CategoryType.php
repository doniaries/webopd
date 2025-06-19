<?php

namespace App\Enums;

enum CategoryType: string
{
    case BERITA = 'Berita';
    case PENGUMUMAN = 'Pengumuman';
    case ARTIKEL = 'Artikel';
    case AGENDA = 'Agenda';
    case DOKUMEN = 'Dokumen';
    case INFOGRAFIS = 'Infografis';
    case HUKUM = 'Hukum';
    case KEGIATAN = 'Kegiatan';
    case PERATURAN = 'Peraturan';
    case LAINNYA = 'Lainnya';

    public function description(): string
    {
        return match ($this) {
            self::BERITA => 'Berita terkini',
            self::PENGUMUMAN => 'Pengumuman resmi',
            self::ARTIKEL => 'Artikel informatif',
            self::AGENDA => 'Jadwal kegiatan',
            self::DOKUMEN => 'Dokumen resmi',
            self::INFOGRAFIS => 'Infografis',
            self::HUKUM => 'Hukum',
            self::KEGIATAN => 'Kegiatan',
            self::PERATURAN => 'Peraturan',
            self::LAINNYA => 'Kategori lainnya',
        };
    }

    public static function toArray(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[] = [
                'name' => $case->value,
                'description' => $case->description(),
                'is_active' => true,
            ];
        }
        return $data;
    }

    public static function toSelectArray(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->value;
        }
        return $options;
    }
}
