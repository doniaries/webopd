<?php

namespace App\Livewire;

use App\Models\Layanan;
use Livewire\Component;

class LayananDetail extends Component
{
    public $layanan;
    public $relatedServices;

    public function mount($layanan)
    {
        $this->layanan = Layanan::where('slug', $layanan)
            ->firstOrFail();

        // Get related services (excluding the current one)
        $this->relatedServices = Layanan::where('id', '!=', $this->layanan->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.layanan-detail');
    }

    public function boot()
    {
        // Set the page title
        if (isset($this->layanan)) {
            view()->share('title', $this->layanan->nama_layanan . ' - ' . config('app.name'));
        }
    }
}
