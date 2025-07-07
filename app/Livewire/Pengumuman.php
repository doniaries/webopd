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
    public $limit = null;
    public $showPagination = true;

    public function render()
    {
        $query = PengumumanModel::latest('published_at')
            ->where('published_at', '<=', now());
            
        if ($this->limit) {
            // Always use paginate with a large number to effectively disable pagination
            $pengumuman = $query->paginate($this->limit);
            $this->showPagination = false;
        } else {
            $pengumuman = $query->paginate($this->perPage);
        }

        return view('livewire.pengumuman', [
            'pengumuman' => $pengumuman,
            'showPagination' => $this->showPagination
        ]);
    }
}
