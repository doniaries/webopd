<?php

namespace App\Livewire;

use App\Models\Informasi as InformasiModel;
use Livewire\Component;
use Livewire\WithPagination;

class Informasi extends Component
{
    use WithPagination;

    public function render()
    {
        $informasi = InformasiModel::query()
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(10);

        return view('livewire.informasi', [
            'informasi' => $informasi,
        ]);
    }
}
