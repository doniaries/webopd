<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
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
        
        // Increment view count when page is loaded
        $this->incrementViews();
    }

    public function render()
    {
        return view('livewire.informasi-detail', [
            'informasi' => $this->informasi,
        ]);
    }
    
    /**
     * Increment the view count for this informasi
     */
    public function incrementViews()
    {
        if ($this->informasi) {
            $this->informasi->increment('views');
            $this->informasi->refresh();
        }
    }
    
    /**
     * Increment the download count for this informasi
     */
    #[On('incrementDownloads')]
    public function incrementDownloads()
    {
        if ($this->informasi) {
            $this->informasi->increment('downloads');
            $this->informasi->refresh();
        }
    }
}
