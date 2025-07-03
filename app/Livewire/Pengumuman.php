<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengumuman as PengumumanModel;
use Livewire\WithPagination;

class Pengumuman extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;

    public function render()
    {
        $pengumuman = PengumumanModel::latest('published_at')
            ->where('published_at', '<=', now())
            ->paginate($this->perPage);

        return view('livewire.pengumuman', [
            'pengumuman' => $pengumuman
        ]);
    }
}
