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
        $this->sambutan = SambutanPimpinanModel::where('team_id', Auth::user()->current_team_id)
            ->first();
    }

    public function render()
    {
        return view('livewire.sambutan-pimpinan', [
            'sambutan' => $this->sambutan
        ]);
    }
}
