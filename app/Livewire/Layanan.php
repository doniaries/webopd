<?php

namespace App\Livewire;

use App\Models\Layanan as LayananModel;
use Livewire\Component;
use Livewire\WithPagination;

class Layanan extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $layanans = LayananModel::query()
            ->when($this->search, function($query) {
                $query->where('nama_layanan', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                      ->orWhere('persyaratan', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.layanan', [
            'layanans' => $layanans
        ]);
    }
}
