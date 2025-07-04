<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Dokumen as DokumenModel;

class Dokumen extends Component
{
    public function render()
    {
        $dokumens = DokumenModel::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('livewire.dokumen', [
            'dokumens' => $dokumens
        ]);
    }
    
    #[On('incrementViews')]
    public function incrementViews($dokumenId)
    {
        $dokumen = DokumenModel::find($dokumenId);
        if ($dokumen) {
            $dokumen->increment('views');
        }
    }
    
    #[On('incrementDownloads')]
    public function incrementDownloads($dokumenId)
    {
        $dokumen = DokumenModel::find($dokumenId);
        if ($dokumen) {
            $dokumen->increment('downloads');
        }
        
        // Return file path for download
        return $dokumen ? $dokumen->file : null;
    }
}
