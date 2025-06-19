<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$agendas = App\Models\AgendaKegiatan::all();

echo "=== DATA TABEL AGENDA KEGIATAN ===\n\n";

if ($agendas->count() > 0) {
    foreach ($agendas as $agenda) {
        echo "ID: {$agenda->id}\n";
        echo "Judul: {$agenda->judul}\n";
        echo "Deskripsi: " . substr(strip_tags($agenda->deskripsi), 0, 100) . "...\n";
        echo "Tempat: {$agenda->tempat}\n";
        echo "Tanggal Mulai: {$agenda->tanggal_mulai}\n";
        echo "Tanggal Selesai: {$agenda->tanggal_selesai}\n";
        echo "Status: " . ($agenda->is_active ? 'Aktif' : 'Tidak Aktif') . "\n";
        echo "Dibuat pada: {$agenda->created_at}\n";
        echo "Diperbarui pada: {$agenda->updated_at}\n";
        echo "\n-----------------------------------\n\n";
    }
} else {
    echo "Tidak ada data agenda kegiatan.\n";
}