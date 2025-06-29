<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UnitKerja as UnitKerjaModel;
use Illuminate\Support\Facades\Auth;

class UnitKerja extends Component
{
    public $unitKerjas;

    public function mount()
    {
        $this->unitKerjas = UnitKerjaModel::all();
    }

    public function render()
    {
        return view('livewire.unitkerja', [
            'unitKerjas' => $this->unitKerjas
        ]);
    }
}
