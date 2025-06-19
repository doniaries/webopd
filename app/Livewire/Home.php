<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Banner;
use App\Models\Slider;
use Illuminate\Support\Facades\Log as LogFacade;
use Illuminate\Support\Str;

class Home extends Component
{
    use WithPagination;

    public $pageTitle = 'Beranda';
    public $pageDescription = 'Selamat datang di website resmi kami';

    public $tags = [];
    public $featuredPosts = [];
    public $latestPosts = [];
    public $banners = [];
    public $sliders = [];
    public $pengumuman = [];
    public $agenda = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        try {
            // Get active tags with post count
            $this->tags = Tag::where('is_active', true)
                ->whereHas('posts', function ($query) {
                    $query->where('status', 'published');
                })
                ->withCount(['posts' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('name')
                ->get() ?? [];

            // Get featured posts (3 latest posts with different categories if possible)
            $this->featuredPosts = Post::where('status', 'published')
                ->with(['tags', 'user'])
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get() ?? [];

            // Get latest posts for hero section
            $this->latestPosts = Post::where('status', 'published')
                ->where('published_at', '<=', now())
                ->with(['tags' => function ($query) {
                    $query->where('is_active', true);
                }, 'user'])
                ->whereHas('tags', function ($query) {
                    $query->where('is_active', true);
                })
                ->latest('published_at')
                ->take(6)
                ->get() ?? [];

            // Get active banners
            $this->banners = Banner::active()->get() ?? [];
            
            // Get active sliders
            $this->sliders = Slider::active()->orderBy('urutan')->get() ?? [];

            // Load pengumuman
            try {
                $pengumumanQuery = \App\Models\Pengumuman::query()
                    ->withoutGlobalScopes() // Temporarily disable global scopes to ensure we get all relevant announcements
                    ->active()
                    ->published()
                    ->where(function($query) {
                        $query->where('team_id', 1) // Always include team_id=1
                              ->orWhere('team_id', Auth::check() ? Auth::user()->current_team_id : 1);
                    })
                    ->orderBy('published_at', 'desc')
                    ->take(5);
                
                $pengumumanCollection = $pengumumanQuery->get();
                $this->pengumuman = $pengumumanCollection->all();
                
                // Debug: Log query yang dihasilkan
                if (app()->environment('local')) {
                    \Illuminate\Support\Facades\Log::info('Pengumuman query:', [
                        'sql' => $pengumumanQuery->toSql(),
                        'bindings' => $pengumumanQuery->getBindings(),
                        'count' => $pengumumanCollection->count()
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error loading pengumuman: ' . $e->getMessage());
                $this->pengumuman = [];
            }
            
            // Get upcoming agenda
            $this->agenda = \App\Models\AgendaKegiatan::query()
                ->where('dari_tanggal', '>=', now())
                ->orderBy('dari_tanggal')
                ->take(3)
                ->get() ?? [];
        } catch (\Exception $e) {
            LogFacade::error('Error in Home@loadData: ' . $e->getMessage());
            $this->tags = [];
            $this->featuredPosts = [];
            $this->banners = [];
            $this->sliders = [];
            $this->pengumuman = [];
            $this->agenda = [];
        }
    }

    public function render()
    {
        // Get all active tags for the menu
        $tags = \App\Models\Tag::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        return view('livewire.home', [
            'pageTitle' => 'Beranda - ' . config('app.name'),
            'pageDescription' => 'Portal resmi ' . config('app.name') . ' untuk informasi terbaru, pengumuman, dan layanan publik.',
            'featuredPosts' => $this->featuredPosts,
            'tags' => $tags,
            'banners' => $this->banners,
            'sliders' => $this->sliders,
            'pengumuman' => $this->pengumuman,
            'agenda' => $this->agenda,
            'pengaturan' => \App\Models\Pengaturan::getFirst()
        ]);
    }
}
