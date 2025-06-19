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
        $this->pengumuman = PengumumanModel::query()
            ->where('slug', $slug)
            ->published()
            ->forCurrentTeam()
            ->firstOrFail();

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
        if ($this->view === 'show') {
            return view('livewire.pengumuman');
        }

        try {
            // Build the base query
            $query = PengumumanModel::query()
                ->withoutGlobalScopes() // Temporarily disable global scopes
                ->active()
                ->published()
                ->where(function($q) {
                    $q->where('team_id', 1) // Always include team_id=1
                      ->orWhere('team_id', $this->teamId); // Include current team's announcements
                });
            
            // Filter by month if selected
            if ($this->bulan) {
                $query->whereYear('published_at', '=', date('Y', strtotime($this->bulan)))
                      ->whereMonth('published_at', '=', date('m', strtotime($this->bulan)));
            }
            
            // Apply search if provided
            if ($this->search) {
                $query->search($this->search);
            }
            
            // Execute the query with pagination
            $pengumuman = $query->orderBy('published_at', 'desc')
                              ->paginate($this->perPage);
            
            // Debug logging in local environment
            if (app()->environment('local')) {
                \Illuminate\Support\Facades\Log::info('Pengumuman query:', [
                    'sql' => $query->toSql(),
                    'bindings' => $query->getBindings(),
                    'count' => $pengumuman->total()
                ]);
            }

            return view('livewire.pengumuman', [
                'pengumuman' => $pengumuman,
            ]);
            
        } catch (\Exception $e) {
            // Log error for debugging
            \Illuminate\Support\Facades\Log::error('Error loading pengumuman: ' . $e->getMessage());
            
            // Return empty collection on error
            return view('livewire.pengumuman', [
                'pengumuman' => new \Illuminate\Pagination\LengthAwarePaginator(
                    [], 0, $this->perPage, 1
                )
            ]);
        }
    }
}
