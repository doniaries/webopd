<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VisiMisi as VisiMisiModel;
use Illuminate\Support\Facades\Auth;

class VisiMisi extends Component
{
    public $visiMisi;

    public function mount()
    {
        $this->visiMisi = VisiMisiModel::where('team_id', Auth::user()->current_team_id)
            ->first();
    }

    public function render()
    {
        return view('livewire.visi-misi', [
            'visiMisi' => $this->visiMisi
        ]);
    }
}
