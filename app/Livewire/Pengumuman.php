<?php

namespace App\Livewire;

use App\Models\Pengumuman as PengumumanModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Pengumuman extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    public $perPage = 10;
    public $pengumuman;
    public $slug;
    public $view = 'index';

    public function mount($slug = null)
    {
        if ($slug) {
            $this->show($slug);
        }
    }

    public function show($slug)
    {
        $this->pengumuman = PengumumanModel::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $this->view = 'show';
        $this->pengumuman->increment('views');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // If showing single pengumuman
        if ($this->view === 'show' && $this->pengumuman) {
            return view('livewire.pengumuman', [
                'view' => 'show',
                'pengumuman' => $this->pengumuman,
            ]);
        }

        try {
            $query = PengumumanModel::query()
                ->where('is_active', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('judul', 'like', '%' . $this->search . '%')
                        ->orWhere('isi', 'like', '%' . $this->search . '%');
                });
            }

            $pengumuman = $query->latest('published_at')
                ->paginate($this->perPage);

            return view('livewire.pengumuman', [
                'pengumuman' => $pengumuman
            ]);
        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error('Error in Pengumuman component: ' . $e->getMessage());
            
            // Return empty collection if there's an error
            return view('livewire.pengumuman', [
                'pengumuman' => PengumumanModel::query()->paginate($this->perPage)
            ]);
        }
    }
}
