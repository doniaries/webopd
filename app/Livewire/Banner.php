<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Banner as BannerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Banner extends Component
{
    public $banners = [];
    
    public function mount()
    {
        $this->loadBanners();
    }
    
    public function loadBanners()
    {
        try {
            $this->banners = BannerModel::where('is_active', true)
                ->latest()
                ->take(5)
                ->get(['id', 'gambar', 'is_active']);
            // Removed verbose logging
        } catch (\Exception $e) {
            // If there's an error (e.g., table doesn't exist), return empty collection
            $this->banners = collect();
        }
    }
    
    public function render()
    {
        return view('livewire.banner', [
            'banners' => $this->banners
        ]);
    }
}
