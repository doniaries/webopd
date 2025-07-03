<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengumuman;
use Livewire\Attributes\Title;

class PengumumanDetail extends Component
{
    public $pengumuman;
    public $slug;

    public function mount($pengumuman)
    {
        $this->pengumuman = Pengumuman::where('slug', $pengumuman)->firstOrFail();
        $this->slug = $pengumuman;
    }

    #[Title('Detail Pengumuman')]
    public function render()
    {
        return view('livewire.pengumuman-detail', [
            'pengumuman' => $this->pengumuman
        ]);
    }
}
