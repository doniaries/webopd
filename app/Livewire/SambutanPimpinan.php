<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SambutanPimpinan as SambutanPimpinanModel;
use Illuminate\Support\Facades\Auth;

class SambutanPimpinan extends Component
{
    public $sambutan;

    public function mount()
    {
        $teamId = Auth::check() ? Auth::user()->current_team_id : 1; // Default to team ID 1 if not authenticated
        $this->sambutan = SambutanPimpinanModel::where('team_id', $teamId)
            ->first();
    }

    public function render()
    {
        return view('livewire.sambutan-pimpinan', [
            'sambutan' => $this->sambutan
        ]);
    }
}
