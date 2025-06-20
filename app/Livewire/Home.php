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
    public $informasi = [];
    public $agenda = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        try {
            // Get tags with published posts
            $this->tags = Tag::whereHas('posts', function ($query) {
                $query->where('status', 'published');
            })
                ->withCount(['posts' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('name')
                ->get() ?? [];

            // Get featured posts (3 latest posts with different tag if possible)
            $this->featuredPosts = Post::where('status', 'published')
                ->with(['tags', 'user'])
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get() ?? [];

            // Get latest posts for hero section
            $this->latestPosts = Post::where('status', 'published')
                ->where('published_at', '<=', now())
                ->with(['tags', 'user'])
                ->whereHas('tags')
                ->latest('published_at')
                ->take(6)
                ->get() ?? [];

            // Get active banners
            $this->banners = Banner::active()->get() ?? [];

            // Get active sliders
            $this->sliders = Slider::active()->orderBy('urutan')->get() ?? [];

            // Load informasi
            try {
                $informasiQuery = \App\Models\Informasi::query()
                    ->withoutGlobalScopes() // Temporarily disable global scopes to ensure we get all relevant announcements
                    ->active()
                    ->published()
                    ->where(function ($query) {
                        $query->where('team_id', 1) // Always include team_id=1
                            ->orWhere('team_id', Auth::check() ? Auth::user()->current_team_id : 1);
                    })
                    ->orderBy('published_at', 'desc')
                    ->take(5);

                $informasiCollection = $informasiQuery->get();
                $this->informasi = $informasiCollection->all();

                // Debug: Log query yang dihasilkan
                if (app()->environment('local')) {
                    \Illuminate\Support\Facades\Log::info('Informasi query:', [
                        'sql' => $informasiQuery->toSql(),
                        'bindings' => $informasiQuery->getBindings(),
                        'count' => $informasiCollection->count()
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error loading informasi: ' . $e->getMessage());
                $this->informasi = [];
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
            $this->informasi = [];
            $this->agenda = [];
        }
    }

    public function render()
    {
        // Get all tags with published posts for the menu
        $tags = \App\Models\Tag::whereHas('posts', function ($query) {
            $query->where('status', 'published');
        })
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        return view('livewire.home', [
            'pageTitle' => 'Beranda - ' . config('app.name'),
            'pageDescription' => 'Portal resmi ' . config('app.name') . ' untuk informasi terbaru, informasi, dan layanan publik.',
            'featuredPosts' => $this->featuredPosts,
            'tags' => $tags,
            'banners' => $this->banners,
            'sliders' => $this->sliders,
            'informasi' => $this->informasi,
            'agenda' => $this->agenda,
            'pengaturan' => \App\Models\Pengaturan::getFirst()
        ]);
    }
}
