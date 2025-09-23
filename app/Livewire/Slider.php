<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Slider as SliderModel;
use App\Models\Post;
use App\Models\Pengaturan;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log as FacadesLog;

class Slider extends Component
{
    /** @var Collection|array */
    public $sliders = [];
    public $pengaturan;
    public $usePostsAsSliders = true; // Flag untuk menggunakan post sebagai slider

    public function mount($sliders = [], $pengaturan = null, $usePostsAsSliders = true)
    {
        $this->pengaturan = $pengaturan ?? Pengaturan::first();
        $this->usePostsAsSliders = true; // Always use posts as sliders

        // Clear any existing sliders
        $this->sliders = [];

        // Always load sliders from posts, ignore the passed in sliders
        $this->loadSliders();
    }

    /**
     * Load sliders from database beserta post dan tags
     */
    public function loadSliders(): void
    {
        $this->sliders = \Illuminate\Support\Facades\Cache::remember('home.sliders', now()->addMinutes(5), function () {
            return \App\Models\Post::with('tags')
                ->orderByDesc('created_at')
                ->take(5) // Jumlah post yang ingin ditampilkan di slider
                ->get();
        });
    }

    public function getFotoUtamaUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function render()
    {
        // Jika tidak ada slider, coba muat ulang
        if (empty($this->sliders) || count($this->sliders) === 0) {
            $this->loadSliders();
        }

        // Do not reload on each render to prevent duplicate queries

        return view('livewire.slider');
    }
}
