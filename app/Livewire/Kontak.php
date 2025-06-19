<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Pengaturan;

class Kontak extends Component
{
    // #[Layout('layouts.app')]
    public function render()
    {
        $pengaturan = Pengaturan::getFirst();

        $title = 'Kontak';
        $description = 'Informasi kontak ' . ($pengaturan ? $pengaturan->nama_instansi : config('app.name'));

        return view('livewire.kontak', [
            'pengaturan' => $pengaturan,
            'title' => $title,
            'description' => $description,
        ]);
    }
}
