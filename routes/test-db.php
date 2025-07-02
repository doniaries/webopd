<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $tables = DB::select('SHOW TABLES');
        
        return [
            'status' => 'Connected',
            'database' => DB::connection()->getDatabaseName(),
            'tables' => $tables,
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'Error',
            'message' => $e->getMessage(),
            'config' => [
                'connection' => config('database.default'),
                'database' => config('database.connections.' . config('database.default') . '.database'),
            ],
        ];
    }
});
