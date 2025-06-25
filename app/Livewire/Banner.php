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
            // Get current team ID
            $teamId = Auth::check() ? Auth::user()->current_team_id : 1;
            
            // Try to get team-specific banners first
            $teamBanners = BannerModel::where('is_active', true)
                ->where('team_id', $teamId)
                ->latest()
                ->take(5)
                ->get();
                
            // If no team-specific banners, get global banners
            if ($teamBanners->isEmpty()) {
                $this->banners = BannerModel::where('is_active', true)
                    ->whereNull('team_id')
                    ->latest()
                    ->take(5)
                    ->get();
            } else {
                $this->banners = $teamBanners;
            }
            
            // Log for debugging
            Log::info('Banners loaded in Banner component', [
                'count' => count($this->banners),
                'team_id' => $teamId
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading banners in Banner component: ' . $e->getMessage());
            $this->banners = [];
        }
    }
    
    public function render()
    {
        return view('livewire.banner', [
            'banners' => $this->banners
        ]);
    }
}
