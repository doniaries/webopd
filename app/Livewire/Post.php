<?php

namespace App\Livewire;

use App\Models\Tag;
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
    public $tag = '';
    #[Url]
    public $sort = 'latest';
    public $perPage = 6;
    public $tags;
    public $tagName;

    // Properties for Show
    public $slug;
    public $relatedPosts;
    public $latestPosts = [];
    public $showPagination = true;
    public $layout = 'grid';
    public $columns = 3;
    public $post;

    // Mount for Index
    public function mount($slug = null, $tag_id = null, $limit = 10, $showPagination = true, $layout = 'grid', $columns = 3)
    {
        $this->slug = $slug;

        if ($slug) {
            $this->show($slug);
        } else {
            $this->tags = Tag::all();
            $this->getLatestPosts();

            // Set properties from parameters
            $this->perPage = $limit;
            $this->showPagination = $showPagination;
            $this->layout = $layout;
            $this->columns = $columns;

            // Handle tag_id if provided
            if ($tag_id) {
                $tag = Tag::find($tag_id);
                if ($tag) {
                    $this->tag = $tag->slug;
                    $this->tagName = $tag->name;
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
            ->with(['tags', 'user'])
            ->latest('published_at')
            ->take(5) // Ambil 5 postingan terbaru (1 untuk utama + 4 untuk grid)
            ->get();
    }

    // Handle index route for /berita
    public function index()
    {
        return view('livewire.posts.index', [
            'tags' => $this->tags,
            'posts' => $this->getPosts()
        ]);
    }

    // Handle route untuk /post/tag/{tag:slug}
    public function tag(\App\Models\Tag $tag)
    {
        $posts = $tag->posts()
            ->published()
            ->latest('published_at')
            ->paginate($this->perPage);

        return view('livewire.posts.tag', [
            'tag' => $tag,
            'posts' => $posts,
            'tags' => \App\Models\Tag::all(),
        ]);
    }

    // Get posts for index page
    protected function getPosts()
    {
        $query = \App\Models\Post::with(['tags', 'user'])
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

        // Apply tag filter
        if ($this->tag) {
            $query->whereHas('tags', function ($q) {
                $q->where('slug', $this->tag);
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
        $this->post = \App\Models\Post::with(['tags', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $this->post->increment('views');

        // Get related posts
        $this->relatedPosts = $this->post->tags()->first()
            ? $this->post->tags()->first()
            ->posts()
            ->where('posts.id', '!=', $this->post->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get()
            : collect();
    }

    // Reset pagination when searching or changing tag
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTag()
    {
        $this->resetPage();
    }

    /**
     * Reset all filters to their default values
     */
    public function resetFilters()
    {
        $this->reset(['search', 'tag', 'sort']);
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
        $viewData = [
            'posts' => $posts,
            'search' => $this->search,
            'tag' => $this->tag,
            'pageTitle' => $this->tagName ? 'Tag: ' . $this->tagName : 'Berita Terbaru',
            'pageDescription' => $this->tagName ? 'Daftar berita dengan tag ' . $this->tagName : 'Daftar lengkap semua berita terbaru',
            'layout' => $this->layout,
            'columns' => $this->columns,
            'showPagination' => $this->showPagination,
            'view' => 'index'
        ];

        // Add pagination links if pagination is enabled
        if ($this->showPagination && method_exists($posts, 'links')) {
            $viewData['posts']->withPath(\Illuminate\Support\Facades\Request::url());
        }

        return view('livewire.post', $viewData);
    }
}
