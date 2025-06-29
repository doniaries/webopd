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
        $teamId = Auth::check() ? Auth::user()->current_team_id : 1; // Default to team ID 1 if not authenticated
        $this->unitKerjas = UnitKerjaModel::where('team_id', $teamId)
            ->get();
    }

    public function render()
    {
        return view('livewire.unitkerja', [
            'unitKerjas' => $this->unitKerjas
        ]);
    }
}
