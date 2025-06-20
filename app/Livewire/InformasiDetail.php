<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Informasi;

class InformasiDetail extends Component
{
    public $slug;
    public $informasi;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->informasi = Informasi::where('slug', $slug)
                                    ->where('published_at', '<=', now())
                                    ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.informasi-detail', [
            'informasi' => $this->informasi,
        ]);
    }
}
