<?php

namespace App\Livewire;

use App\Models\ExternalLink;
use Livewire\Component;

class ExternalLinks extends Component
{
    public $links;
    public $limit = 8; // Jumlah link yang ditampilkan

    public function mount($limit = 8)
    {
        $this->limit = $limit;
        $this->loadLinks();
    }

    public function loadLinks()
    {
        $this->links = ExternalLink::orderBy('nama_link')
            ->limit($this->limit)
            ->get();
    }

    public function render()
    {
        $links = ExternalLink::all();

        return view('livewire.external-links', [
            'links' => $links
        ]);
    }
}
