<?php

namespace App\Livewire;

use App\Models\Informasi as InformasiModel;
use Livewire\Component;
use Livewire\WithPagination;

class Informasi extends Component
{
    use WithPagination;

    public $perPage = 12;

    public function render()
    {
        $informasi = InformasiModel::query()
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate($this->perPage);

        return view('livewire.informasi', [
            'informasi' => $informasi,
        ]);
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }
}
