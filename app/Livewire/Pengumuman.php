<?php

namespace App\Livewire;

use App\Models\Pengumuman as PengumumanModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Pengumuman extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $bulan = '';

    public $perPage = 6;
    public $pengumuman;
    public $slug;
    public $view = 'index';
    protected $teamId;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'bulan' => ['except' => ''],
    ];
    
    public function mount($slug = null)
    {
        // Default to team_id = 1 if not logged in
        $this->teamId = 1;
        if (Auth::check() && Auth::user()->currentTeam) {
            $this->teamId = Auth::user()->currentTeam->id;
        }
        
        if ($slug) {
            $this->show($slug);
        }
        
        // Set default bulan to current month if not set
        if (empty($this->bulan)) {
            $this->bulan = now()->format('Y-m');
        }
    }

    public function show($slug)
    {
        $query = PengumumanModel::where('slug', $slug)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
            
        $query->where('team_id', $this->teamId);
            
        $this->pengumuman = $query->firstOrFail();

        $this->view = 'show';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingBulan()
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
                ->where('published_at', '<=', now())
                ->when($this->bulan, function($q) {
                    $q->whereYear('published_at', '=', date('Y', strtotime($this->bulan)))
                      ->whereMonth('published_at', '=', date('m', strtotime($this->bulan)));
                })
                ->when($this->search, function($q) {
                    $q->where(function($query) {
                        $query->where('judul', 'like', '%' . $this->search . '%')
                              ->orWhere('isi', 'like', '%' . $this->search . '%');
                    });
                });
                
            $query->where('team_id', $this->teamId);
            
            $query->latest('published_at');

            $pengumuman = $query->paginate($this->perPage);
            
            // If no results for selected month, show all announcements
            if ($pengumuman->isEmpty() && $this->bulan) {
                $this->bulan = '';
                return $this->render();
            }

            return view('livewire.pengumuman', [
                'pengumuman' => $pengumuman
            ]);
        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error('Error in Pengumuman component: ' . $e->getMessage());
            
            // Return empty collection if there's an error
            return view('livewire.pengumuman', [
                'pengumuman' => PengumumanModel::where('team_id', $this->teamId)
                    ->where('is_active', true)
                    ->latest('published_at')
                    ->paginate($this->perPage)
            ]);
        }
    }
}
