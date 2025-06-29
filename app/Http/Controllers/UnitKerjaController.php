<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Display the specified unit kerja.
     *
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\View\View
     */
    public function show(UnitKerja $unitKerja)
    {
        return view('unit-kerja.detail', [
            'unit' => $unitKerja
        ]);
    }
}
