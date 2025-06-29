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
        $this->sambutan = SambutanPimpinanModel::first();
    }

    public function render()
    {
        return view('livewire.sambutan-pimpinan', [
            'sambutan' => $this->sambutan
        ]);
    }
}
