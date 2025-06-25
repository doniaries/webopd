<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Slider as SliderModel;
use App\Models\Post;
use App\Models\Pengaturan;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log as FacadesLog;

class Slider extends Component
{
    /** @var Collection|array */
    public $sliders = [];
    public $pengaturan;
    public $usePostsAsSliders = true; // Flag untuk menggunakan post sebagai slider

    public function mount($sliders = [], $pengaturan = null, $usePostsAsSliders = true)
    {
        $this->pengaturan = $pengaturan ?? Pengaturan::first();
        $this->usePostsAsSliders = true; // Always use posts as sliders

        \Illuminate\Support\Facades\Log::info('Slider mount - usePostsAsSliders: ' . ($this->usePostsAsSliders ? 'true' : 'false'));

        // Clear any existing sliders
        $this->sliders = [];

        // Always load sliders from posts, ignore the passed in sliders
        \Illuminate\Support\Facades\Log::info('Memanggil loadSliders()');
        $this->loadSliders();

        // Log the loaded sliders for debugging
        \Illuminate\Support\Facades\Log::info('Loaded sliders:', [
            'count' => count($this->sliders),
            'type' => $this->sliders instanceof Collection ? 'Collection' : gettype($this->sliders),
            'first_item' => !empty($this->sliders) ? get_class(collect($this->sliders)->first()) : 'empty'
        ]);
    }

    /**
     * Load sliders from posts or fallback to regular sliders
     *
     * @return void
     */
    public function loadSliders(): void
    {
        try {
            // Always try to get posts first if usePostsAsSliders is true
            if ($this->usePostsAsSliders) {
                // Debug query to see what's in the database
                \Illuminate\Support\Facades\Log::info('Checking posts table for featured posts...');

                // Get latest published posts with proper eager loading, ordered by published date (newest first)
                $rawPosts = Post::query()
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->with(['tags', 'user'])
                    ->latest('published_at') // Orders by published_at in descending order (newest first)
                    ->take(5)
                    ->get();

                \Illuminate\Support\Facades\Log::info('Found ' . $rawPosts->count() . ' featured posts');

                if ($rawPosts->isNotEmpty()) {
                    $mappedPosts = $rawPosts->map(function (Post $post) {
                        // Use post's main image or fallback to placeholder
                        $imageUrl = $post->foto_utama_url ?: asset('placeholder.jpg');

                        $mapped = [
                            'id' => $post->id,
                            'judul' => $post->title,
                            'deskripsi' => $post->excerpt ?? substr(strip_tags($post->content), 0, 150) . '...',
                            'gambar_url' => $imageUrl,
                            'url' => route('berita.show', $post->slug),
                            'is_post' => true,
                            'post' => $post,
                            'published_at' => $post->published_at,
                            'author_name' => $post->user->name ?? 'Admin',
                            'tags' => $post->tags->pluck('name')->toArray()
                        ];

                        \Illuminate\Support\Facades\Log::info('Mapped post', [
                            'id' => $post->id,
                            'title' => $post->title,
                            'image_url' => $imageUrl,
                            'has_image' => !empty($post->foto_utama_url)
                        ]);

                        return (object) $mapped;
                    });

                    // Convert to array to ensure proper serialization
                    $this->sliders = $mappedPosts->values()->all();
                    \Illuminate\Support\Facades\Log::info('Set sliders property', [
                        'count' => count($this->sliders),
                        'type' => gettype($this->sliders),
                        'first_item' => !empty($this->sliders) ? gettype(reset($this->sliders)) : 'empty'
                    ]);
                    return;
                }
            }

            // Fallback to regular sliders if no featured posts found or usePostsAsSliders is false
            $this->sliders = SliderModel::where('is_active', true)
                ->orderBy('urutan')
                ->get();

            // If no sliders at all, create a default one
            if ($this->sliders->isEmpty()) {
                $this->sliders = collect([
                    (object) [
                        'judul' => 'Selamat Datang di Portal Resmi',
                        'deskripsi' => 'Portal resmi untuk informasi dan layanan publik.',
                        'gambar_url' => asset('assets/img/hero-img.png'),
                        'url' => route('berita.index'),
                        'is_post' => false,
                        'published_at' => now()
                    ]
                ]);
            }
        } catch (\Exception $e) {
            // Log the error but don't break the page
            \Illuminate\Support\Facades\Log::error('Error in Slider@loadSliders: ' . $e->getMessage());
            $this->sliders = [];
        }
    }




    public function render()
    {
        // Log jumlah slider sebelum render
        Log::info('Slider render - Jumlah slider: ' . count($this->sliders));

        // Jika tidak ada slider, coba muat ulang
        if (empty($this->sliders) || count($this->sliders) === 0) {
            Log::warning('Tidak ada slider untuk ditampilkan, mencoba memuat ulang');
            $this->loadSliders();
        }

        if ($this->usePostsAsSliders) {
            $this->loadSliders();
        }

        return view('livewire.slider');
    }
}
