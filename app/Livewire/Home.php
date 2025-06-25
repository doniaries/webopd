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
use App\Livewire\RandomNews;

class Home extends Component
{
    use WithPagination;

    public $pageTitle = 'Beranda';
    public $pageDescription = 'Selamat datang di website resmi kami';

    public $tags = [];
    public $featuredPosts = [];
    public $latestPosts = [];
    /** @var \Illuminate\Support\Collection<object{judul: string, gambar_url: string, url: string, is_banner: bool}> */
    public $banners;
    public $sliders = [];
    public $informasi = [];
    /** @var \Illuminate\Support\Collection */
    public $agenda;
    public $popularPosts = [];
    public $dokumens = [];

    public function mount()
    {
        $this->banners = collect();
        $this->agenda = collect();
        $this->loadData();
    }

    public function loadData()
    {
        try {
            // Load banners first
            $this->loadBanners();
            
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

            // Get popular posts (most viewed)
            $this->popularPosts = Post::where('status', 'published')
                ->where('published_at', '<=', now())
                ->with(['categories' => function ($q) {
                    $q->where('is_active', true);
                }, 'user'])
                ->orderBy('views', 'desc')
                ->take(8)
                ->get() ?? [];

            // Load active banners for the current team
            $this->loadBanners();

            // Get active sliders
            $this->sliders = Slider::active()->orderBy('urutan')->get() ?? [];

            // Load informasi
            try {
                $informasiQuery = \App\Models\Informasi::query()
                    ->withoutGlobalScopes() // Temporarily disable global scopes to ensure we get all relevant announcements
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

            // Get agenda (events)
            $agenda = \App\Models\AgendaKegiatan::where('is_published', true)
                ->where('published_at', '<=', now())
                ->where('end_date', '>=', now())
                ->select([
                    'id',
                    'nama_agenda',
                    'uraian_agenda',
                    'tempat',
                    'penyelenggara',
                    'dari_tanggal',
                    'sampai_tanggal',
                    'waktu_mulai',
                    'waktu_selesai',
                    'team_id'
                ])
                ->where('dari_tanggal', '>=', now())
                ->orderBy('dari_tanggal')
                ->orderBy('waktu_mulai')
                ->take(3)
                ->get();
            $this->agenda = collect($agenda);

            // Debug: Log agenda data
            if (app()->environment('local')) {
                \Illuminate\Support\Facades\Log::info('Agenda data:', [
                    'count' => $this->agenda->count(),
                    'first_item' => $this->agenda->first()
                ]);
            }
            
            // Get latest dokumens with views and downloads
            try {
                $this->dokumens = \App\Models\Dokumen::orderBy('created_at', 'desc')
                    ->select(['id', 'nama_dokumen', 'deskripsi', 'cover', 'file', 'tahun_terbit', 'views', 'downloads'])
                    ->take(3)
                    ->get();
                    
                if (app()->environment('local')) {
                    \Illuminate\Support\Facades\Log::info('Dokumen data:', [
                        'count' => $this->dokumens->count()
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error loading dokumens: ' . $e->getMessage());
                $this->dokumens = collect();
            }
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

    /**
     * Load active banners for the current team
     *
     * @return void
     */
    /**
     * @return \Illuminate\Support\Collection<object{judul: string, gambar_url: string, url: string, is_banner: bool}>
     */
    protected function loadBannersData()
    {
        try {
            // Get pengaturan with team relationship
            $pengaturan = \App\Models\Pengaturan::with('team')->first();
            $teamId = $pengaturan->team_id ?? null;
            $teamName = $pengaturan->team->name ?? 'No Team';

            \Illuminate\Support\Facades\Log::info('Loading banners', [
                'team_id' => $teamId,
                'team_name' => $teamName,
                'pengaturan_exists' => $pengaturan ? 'Yes' : 'No'
            ]);

            // Start building the query for team-specific banners
            $query = \App\Models\Banner::where('is_active', true);
            
            if (!is_null($teamId)) {
                // First try to get team-specific banners
                $teamBanners = (clone $query)
                    ->where('team_id', $teamId)
                    ->latest()
                    ->take(4)
                    ->get();

                // If no team-specific banners found, get global banners (where team_id is null)
                if ($teamBanners->isEmpty()) {
                    $banners = (clone $query)
                        ->whereNull('team_id')
                        ->latest()
                        ->take(4)
                        ->get();
                } else {
                    $banners = $teamBanners;
                }
            } else {
                // If no team_id is set, only get global banners
                $banners = $query->whereNull('team_id')
                    ->latest()
                    ->take(4)
                    ->get();
            }

            // Log the results for debugging
            \Illuminate\Support\Facades\Log::info('Banners loaded', [
                'team_id' => $teamId,
                'banners_count' => $banners->count(),
                'banner_ids' => $banners->pluck('id')->toArray(),
                'banners' => $banners->toArray()
            ]);

            // Map the banners to the required format
            return $banners->map(function ($banner) {
                // Ensure the image path is correct
                $gambarUrl = null;
                if (!empty($banner->gambar)) {
                    // Remove any leading slashes or backslashes from the path
                    $cleanPath = ltrim($banner->gambar, '/\\');
                    
                    // Check if the file exists in storage
                    $storagePath = storage_path('app/public/' . $cleanPath);
                    
                    if (file_exists($storagePath)) {
                        $gambarUrl = asset('storage/' . $cleanPath);
                    } else {
                        // Try with the original path if clean path doesn't exist
                        $storagePath = storage_path('app/public/' . $banner->gambar);
                        if (file_exists($storagePath)) {
                            $gambarUrl = asset('storage/' . $banner->gambar);
                        }
                    }
                    
                    // Log if image not found
                    if (!$gambarUrl) {
                        \Illuminate\Support\Facades\Log::warning('Banner image not found', [
                            'banner_id' => $banner->id,
                            'gambar' => $banner->gambar,
                            'storage_path' => $storagePath
                        ]);
                    }
                }
                
                // Fallback to default image if no valid image found
                if (!$gambarUrl) {
                    $gambarUrl = asset('assets/img/hero-img.png');
                }
                
                return (object) [
                    'id' => $banner->id,
                    'judul' => $banner->judul ?? 'Banner ' . $banner->id,
                    'gambar_url' => $gambarUrl,
                    'url' => $banner->keterangan ?: '#',
                    'is_banner' => true,
                    'team_id' => $banner->team_id
                ];
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in loadBannersData: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return collect();
        }
    }

    public function loadBanners(): void
    {
        try {
            $banners = $this->loadBannersData();
            $this->banners = $banners;
            
            // Debug log
            \Illuminate\Support\Facades\Log::info('Banners loaded:', [
                'count' => $banners->count(),
                'banners' => $banners->toArray(),
                'team_id' => \App\Models\Pengaturan::first()?->team_id
            ]);
            
            if ($banners->isEmpty()) {
                \Illuminate\Support\Facades\Log::warning('No active banners found for team');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error loading banners: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);
            $this->banners = collect();
        }
    }

    public function render()
    {
        // Load banners if not already loaded or empty
        if (!isset($this->banners) || (is_array($this->banners) && empty($this->banners)) || 
            ($this->banners instanceof \Illuminate\Support\Collection && $this->banners->isEmpty())) {
            $this->loadBanners();
        }

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
            'banners' => $this->banners,
            'featuredPosts' => $this->featuredPosts,
            'tags' => $tags,
            'banners' => $this->banners,
            'sliders' => $this->sliders,
            'informasi' => $this->informasi,
            'agenda' => $this->agenda,
            'pengaturan' => \App\Models\Pengaturan::getFirst(),
            'popularPosts' => $this->popularPosts,
            'dokumens' => $this->dokumens,
        ]);
    }
}
