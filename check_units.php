<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illwarehouse\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Check units
try {
    $units = \App\Models\UnitKerja::all();
    echo "Found " . $units->count() . " units:\n";
    foreach ($units as $unit) {
        echo "- " . $unit->nama_unit . " (" . $unit->slug . ")\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
