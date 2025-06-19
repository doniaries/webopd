<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Slider;
use Illuminate\Support\Facades\Log as LogFacade;
use Illuminate\Support\Str;

class Home extends Component
{
    use WithPagination;

    public $pageTitle = 'Beranda';
    public $pageDescription = 'Selamat datang di website resmi kami';

    public $kategoriBerita = [];
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
            // Get active categories with post count
            $this->kategoriBerita = Category::where('is_active', true)
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
                ->with(['categories', 'user'])
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get() ?? [];

            // Get latest posts for hero section
            $this->latestPosts = Post::where('status', 'published')
                ->where('published_at', '<=', now())
                ->with(['categories' => function ($query) {
                    $query->where('is_active', true);
                }, 'user'])
                ->whereHas('categories', function ($query) {
                    $query->where('is_active', true);
                })
                ->latest('published_at')
                ->take(6)
                ->get() ?? [];

            // Get active banners
            $this->banners = Banner::active()->get() ?? [];
            
            // Get active sliders
            $this->sliders = Slider::active()->orderBy('urutan')->get() ?? [];
            
            // Get active pengumuman
            $this->pengumuman = \App\Models\Pengumuman::query()
                ->where('is_active', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->take(5)
                ->get() ?? [];
                
            // Get upcoming agenda
            $this->agenda = \App\Models\AgendaKegiatan::query()
                ->where('dari_tanggal', '>=', now())
                ->orderBy('dari_tanggal')
                ->take(3)
                ->get() ?? [];
        } catch (\Exception $e) {
            LogFacade::error('Error in Home@loadData: ' . $e->getMessage());
            $this->kategoriBerita = [];
            $this->featuredPosts = [];
            $this->banners = [];
            $this->sliders = [];
            $this->pengumuman = [];
            $this->agenda = [];
        }
    }

    public function render()
    {
        // Get all active categories for the menu
        $categories = \App\Models\Category::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        return view('livewire.home', [
            'pageTitle' => 'Beranda - ' . config('app.name'),
            'pageDescription' => 'Portal resmi ' . config('app.name') . ' untuk informasi terbaru, pengumuman, dan layanan publik.',
            'featuredPosts' => $this->featuredPosts,
            'categories' => $categories,
            'banners' => $this->banners,
            'sliders' => $this->sliders,
            'pengumuman' => $this->pengumuman,
            'agenda' => $this->agenda,
            'pengaturan' => \App\Models\Pengaturan::getFirst()
        ]);
    }
}
