<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Slider as SliderModel;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Log;

class Slider extends Component
{
    public $sliders = [];
    public $pengaturan;
    
    public function mount($sliders = [], $pengaturan = null)
    {
        $this->pengaturan = $pengaturan ?? Pengaturan::first();
        
        if (!empty($sliders) && count($sliders) > 0) {
            $this->sliders = $sliders;
        } else {
            $this->loadSliders();
        }
    }
    
    public function loadSliders()
    {
        try {
            // Get active sliders ordered by urutan
            $this->sliders = SliderModel::where('is_active', true)
                ->orderBy('urutan')
                ->get();
            
            // If no sliders, create a default one
            if ($this->sliders->isEmpty()) {
                $this->sliders = collect([
                    (object) [
                        'judul' => 'Selamat Datang di Portal Resmi',
                        'deskripsi' => 'Portal resmi untuk informasi dan layanan publik.',
                        'gambar_url' => asset('assets/img/hero-img.png'),
                        'background_color' => '#ffffff',
                        'text_color' => '#000000',
                        'button_text' => 'Lihat Berita',
                        'button_link' => url(route('berita.index')),
                    ]
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in Slider@loadSliders: ' . $e->getMessage());
            $this->sliders = collect();
        }
    }
    
    public function render()
    {
        return view('livewire.slider');
    }
}
