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

        \Illuminate\Support\Facades\Log::info('Slider mount - usePostsAsSliders: ' . ($this->usePostsAsSliders ? 'true' : 'false'));

        // Clear any existing sliders
        $this->sliders = [];

        // Always load sliders from posts, ignore the passed in sliders
        \Illuminate\Support\Facades\Log::info('Memanggil loadSliders()');
        $this->loadSliders();

        // Log the loaded sliders for debugging
        \Illuminate\Support\Facades\Log::info('Loaded sliders:', [
            'count' => count($this->sliders),
            'type' => $this->sliders instanceof \Illuminate\Support\Collection ? 'Collection' : gettype($this->sliders),
            'first_item' => !empty($this->sliders) ? get_class(collect($this->sliders)->first()) : 'empty'
        ]);
    }

    /**
     * Load sliders from database beserta post dan tags
     */
    public function loadSliders(): void
    {
        $this->sliders = \App\Models\Post::with('tags')
            ->orderByDesc('created_at')
            ->take(5) // Jumlah post yang ingin ditampilkan di slider
            ->get();
    }


    public function render()
    {
        // Log jumlah slider sebelum render
        Log::info('Slider render - Jumlah slider: ' . count($this->sliders));

        // Jika tidak ada slider, coba muat ulang
        if (empty($this->sliders) || count($this->sliders) === 0) {
            Log::warning('Tidak ada slider untuk ditampilkan, mencoba memuat ulang');
            $this->loadSliders();
        }

        if ($this->usePostsAsSliders) {
            $this->loadSliders();
        }

        return view('livewire.slider');
    }
}
