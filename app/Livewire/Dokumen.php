<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Dokumen as DokumenModel;

class Dokumen extends Component
{
    public function render()
    {
        $dokumens = DokumenModel::orderBy('created_at', 'desc')->get();
        return view('livewire.dokumen', compact('dokumens'));
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
