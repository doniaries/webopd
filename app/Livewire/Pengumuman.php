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
    public $limit = 3; // default tampil 3 item agar tidak terlalu panjang
    public $showPagination = true;

    public function render()
    {
        $query = PengumumanModel::latest('published_at')
            ->where('published_at', '<=', now());
            
        // Pada halaman index pengumuman, gunakan pagination penuh
        if (request()->routeIs('pengumuman.index')) {
            $pengumuman = $query->paginate($this->perPage);
            $this->showPagination = true;
        } else {
            // Default di lokasi lain (mis. homepage/sidebar): batasi jumlah item
            $limit = $this->limit ?: 3;
            $pengumuman = $query->paginate($limit);
            $this->showPagination = false;
        }

        return view('livewire.pengumuman', [
            'pengumuman' => $pengumuman,
            'showPagination' => $this->showPagination
        ]);
    }
}
