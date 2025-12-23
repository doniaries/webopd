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
    public $loading = true;
    public $pageDescription = 'Selamat datang di website resmi kami';

    public $tags = [];
    public $featuredPosts = [];
    public $latestPosts = [];
    /** @var \Illuminate\Support\Collection<object{judul: string, gambar_url: string, url: string, is_banner: bool}> */
    public $banners;
    public $sliders = [];
    /** @var \Illuminate\Support\Collection */
    public $agenda;
    public $popularPosts = [];
    public $dokumens = [];

    public function mount()
    {
        $this->banners = collect();
        $this->agenda = collect();
        $this->loading = true;
        $this->loadData();
        $this->loading = false;
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
                ->with(['tags', 'user'])
                ->orderBy('views', 'desc')
                ->take(8)
                ->get() ?? [];

            // Get active sliders
            $this->sliders = Slider::active()->get() ?? [];

            // Get agenda (events)
            $agenda = \App\Models\AgendaKegiatan::where('dari_tanggal', '>=', now()->toDateString())
                ->where('sampai_tanggal', '>=', now()->toDateString())
                ->select([
                    'id',
                    'nama_agenda',
                    'uraian_agenda',
                    'tempat',
                    'penyelenggara',
                    'dari_tanggal',
                    'sampai_tanggal',
                    'waktu_mulai',
                    'waktu_selesai'
                ])
                ->where('dari_tanggal', '>=', now())
                ->orderBy('dari_tanggal')
                ->orderBy('waktu_mulai')
                ->take(3)
                ->get();
            $this->agenda = collect($agenda);

            // Get latest dokumens with views and downloads
            try {
                $this->dokumens = \App\Models\Dokumen::orderBy('created_at', 'desc')
                    ->select(['id', 'nama_dokumen', 'deskripsi', 'cover', 'file', 'tahun_terbit', 'views', 'downloads'])
                    ->take(3)
                    ->get();

                // Removed verbose dokumen info logging
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
            $this->agenda = [];
        }
    }



    protected function loadBannersData()
    {
        try {
            // Get active banners
            $banners = \App\Models\Banner::where('is_active', true)
                ->latest()
                ->take(5)
                ->get();

            return $banners->map(function ($banner) {
                return (object)[
                    'id' => $banner->id,
                    'gambar_url' => $banner->gambar_url,
                    'url' => $banner->url ?: '#',
                    'is_banner' => true
                ];
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error loading banners: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Load banners and update the component state
     */
    public function loadBanners(): void
    {
        $this->banners = $this->loadBannersData();
    }

    public function render()
    {
        // Load banners if not already loaded or empty
        if (
            !isset($this->banners) || (is_array($this->banners) && empty($this->banners)) ||
            ($this->banners instanceof \Illuminate\Support\Collection && $this->banners->isEmpty())
        ) {
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

        // Get active theme
        $pengaturan = \App\Models\Pengaturan::first();
        $activeTheme = $pengaturan->active_theme ?? 'default';

        // Define view path
        $viewPath = 'livewire.home'; // Default view
        if ($activeTheme !== 'default' && view()->exists('themes.' . $activeTheme . '.home')) {
            return view('themes.' . $activeTheme . '.home', [
                'pageTitle' => 'Beranda - ' . config('app.name'),
                'pageDescription' => 'Portal resmi ' . config('app.name') . ' untuk informasi terbaru, informasi, dan layanan publik.',
                'featuredPosts' => $this->featuredPosts,
                'tags' => $tags,
                'banners' => $this->banners,
                'sliders' => $this->sliders,
                'agenda' => $this->agenda,
                'pengaturan' => \App\Models\Pengaturan::first(),
                'popularPosts' => $this->popularPosts,
                'dokumens' => $this->dokumens,
            ])->layout('themes.' . $activeTheme . '.layouts.app', [
                'tags' => $tags,
                'pengaturan' => \App\Models\Pengaturan::first(),
                'pageTitle' => 'Beranda - ' . config('app.name'),
                'pageDescription' => 'Portal resmi ' . config('app.name') . ' untuk informasi terbaru, informasi, dan layanan publik.',
            ]);
        }

        return view($viewPath, [
            'pageTitle' => 'Beranda - ' . config('app.name'),
            'pageDescription' => 'Portal resmi ' . config('app.name') . ' untuk informasi terbaru, informasi, dan layanan publik.',
            'featuredPosts' => $this->featuredPosts,
            'tags' => $tags,
            'banners' => $this->banners,
            'sliders' => $this->sliders,
            'agenda' => $this->agenda,
            'pengaturan' => \App\Models\Pengaturan::first(),
            'popularPosts' => $this->popularPosts,
            'dokumens' => $this->dokumens,
        ]);
    }
}
