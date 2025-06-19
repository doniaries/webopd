<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Post extends Component
{
    use WithPagination;

    // Properties for Index
    #[Url]
    public $search = '';
    #[Url]
    public $category = '';
    #[Url]
    public $sort = 'latest';
    public $perPage = 10;
    public $categories;
    public $categoryName;

    // Properties for Show
    public $slug;
    public $relatedPosts;
    public $latestPosts = [];
    public $showPagination = true;
    public $layout = 'grid';
    public $columns = 3;
    public $post;

    // Mount for Index
    public function mount($slug = null, $category_id = null, $limit = 10, $showPagination = true, $layout = 'grid', $columns = 3)
    {
        $this->slug = $slug;
        
        if ($slug) {
            $this->show($slug);
        } else {
            $this->categories = Category::where('is_active', true)->get();
            $this->getLatestPosts();
            
            // Set properties from parameters
            $this->perPage = $limit;
            $this->showPagination = $showPagination;
            $this->layout = $layout;
            $this->columns = $columns;
            
            // Handle category_id if provided
            if ($category_id) {
                $category = Category::find($category_id);
                if ($category) {
                    $this->category = $category->slug;
                    $this->categoryName = $category->name;
                }
            }
        }
    }

    // Get latest posts
    protected function getLatestPosts()
    {
        $this->latestPosts = \App\Models\Post::query()
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->with(['category', 'user'])
            ->latest('published_at')
            ->take(5) // Ambil 5 postingan terbaru (1 untuk utama + 4 untuk grid)
            ->get();
    }

    // Handle index route for /berita
    public function index()
    {
        return view('livewire.posts.index', [
            'categories' => $this->categories,
            'posts' => $this->getPosts()
        ]);
    }

    // Get posts for index page
    protected function getPosts()
    {
        $query = \App\Models\Post::with(['category', 'user'])
            ->where('status', 'published')
            ->where('published_at', '<=', now());

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if ($this->category) {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->category);
            });
        }

        // Apply sorting
        switch ($this->sort) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default: // latest
                $query->latest('published_at');
        }

        if ($this->showPagination) {
            return $query->paginate($this->perPage);
        }
        
        return $query->take($this->perPage)->get();
    }

    // Show single post
    public function show($slug)
    {
        $this->post = \App\Models\Post::with(['category', 'user', 'categories'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $this->post->increment('views');

        // Get related posts
        $this->relatedPosts = \App\Models\Post::where('category_id', $this->post->category_id)
            ->where('id', '!=', $this->post->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    // Reset pagination when searching or changing category
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    /**
     * Reset all filters to their default values
     */
    public function resetFilters()
    {
        $this->reset(['search', 'category', 'sort']);
    }

    public function render()
    {
        // If showing single post
        if ($this->post) {
            return view('livewire.post', [
                'view' => 'show',
                'post' => $this->post,
                'relatedPosts' => $this->relatedPosts,
                'pageTitle' => $this->post->title,
                'pageDescription' => $this->post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($this->post->content), 160)
            ]);
        }

        // Get posts based on current filters
        $posts = $this->getPosts();

        // Prepare view data for index view
        return view('livewire.post', [
            'posts' => $posts,
            'categories' => $this->categories,
            'search' => $this->search,
            'category' => $this->category,
            'pageTitle' => $this->categoryName ? 'Kategori: ' . $this->categoryName : 'Berita Terbaru',
            'pageDescription' => $this->categoryName ? 'Daftar berita dalam kategori ' . $this->categoryName : 'Daftar lengkap semua berita terbaru',
            'layout' => $this->layout,
            'columns' => $this->columns,
            'showPagination' => $this->showPagination,
            'view' => 'index'
        ]);
    }
}
