<div x-data="{ loading: false }" x-on:livewire:start="loading = true" x-on:livewire:finish="loading = false" class="relative">
    @if ($view === 'index') <x-page-header :title="$pageTitle" />
    <div class="container mx-auto px-4 py-8">


        <!-- Jumlah Berita dan Filter -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl font-semibold text-gray-800">
                @if (isset($tagName))
                Berita {{ $tagName }}
                @else
                Semua Berita
                @endif
                <span class="ml-2 text-sm font-normal text-gray-500">
                    ({{ $posts->total() }} berita ditemukan)
                </span>
            </h2>

            <!-- Tampilkan opsi tampilan (grid/list) jika diperlukan -->
            <div class="flex space-x-2">
                <button wire:click="$set('layout', 'grid')"
                    class="p-2 rounded-md {{ $layout === 'grid' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}"
                    title="Tampilan Grid">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </button>
                <button wire:click="$set('layout', 'list')"
                    class="p-2 rounded-md {{ $layout === 'list' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}"
                    title="Tampilan Daftar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        @php
        // Get the latest 5 posts for the slider
        $featuredPosts = $posts->take(5);
        // Get the remaining posts for the grid
        $gridPosts = $posts->skip(5);
        @endphp

        <!-- News Slider -->
        <div class="relative mb-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div x-data="{
                    currentSlide: 0,
                    slides: {{ $featuredPosts }},
                    next() {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    },
                    prev() {
                        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                    },
                    init() {
                        setInterval(() => {
                            this.next();
                        }, 5000);
                    }
                }" class="relative">
                <!-- Slider Content -->
                <div class="relative h-96">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="currentSlide === index" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="absolute inset-0">
                            <!-- Slide Image -->
                            <template
                                x-if="!slide.foto_utama_url || typeof slide.foto_utama_url !== 'string' || !slide.foto_utama_url.startsWith('http')">
                                <div x-data="{
                                        placeholderData: (() => {
                                            try {
                                                return typeof slide.foto_utama_url === 'string' ? JSON.parse(slide.foto_utama_url) : slide.foto_utama_url;
                                            } catch (e) {
                                                return { type: 'placeholder', bg_color: 'bg-gray-200', text: 'Gambar tidak tersedia' };
                                            }
                                        })()
                                    }" class="w-full h-full flex items-center justify-center"
                                    :class="placeholderData.bg_color || 'bg-gray-200'">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500"
                                            x-text="placeholderData.text || 'Gambar tidak tersedia'"></span>
                                    </div>
                                </div>
                            </template>
                            <img x-show="slide.foto_utama_url && typeof slide.foto_utama_url === 'string' && slide.foto_utama_url.startsWith('http')"
                                :src="slide.foto_utama_url" :alt="slide.title"
                                class="w-full h-full object-cover">

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                            </div>

                            <!-- Slide Content -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <!-- Category Badge -->
                                <div class="mb-3">
                                    <span
                                        class="inline-block bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        <span x-text="slide.tag?.name || 'Berita'"></span>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h2 class="text-2xl md:text-3xl font-bold mb-3 leading-tight">
                                    <a :href="'{{ url('/posts') }}/' + slide.slug" class="hover:underline"
                                        x-text="slide.title"></a>
                                </h2>

                                <!-- Date and Views -->
                                <div class="flex items-center text-sm text-gray-200">
                                    <span class="flex items-center mr-4">
                                        <i class="far fa-clock mr-1"></i>
                                        <span
                                            x-text="new Date(slide.published_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></span>
                                    </span>
                                    <span class="flex items-center">
                                        <i class="far fa-eye mr-1"></i>
                                        <span x-text="slide.views + 'x dilihat'"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Navigation Arrows -->
                    <button @click="prev()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="next()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Slider Indicators -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                        <template x-for="(slide, index) in slides" :key="'indicator-' + index">
                            <button @click="currentSlide = index" class="w-2.5 h-2.5 rounded-full transition-colors"
                                :class="{ 'bg-white': currentSlide === index, 'bg-white/50': currentSlide !== index }"
                                :aria-label="'Go to slide ' + (index + 1)"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Slider Footer -->
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Geser untuk melihat berita lainnya</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="prev()" class="p-1 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button @click="next()" class="p-1 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 {{ $layout === 'grid' ? 'md:grid-cols-2 lg:grid-cols-3' : '' }} gap-6">
            @forelse($gridPosts as $post)
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow h-full flex flex-col bg-white">
                @php
                $isPlaceholder = false;
                $placeholderData = [];

                if ($post->foto_utama_url) {
                if (
                is_string($post->foto_utama_url) &&
                str_starts_with($post->foto_utama_url, '{"type"')
                ) {
                try {
                $placeholderData = json_decode($post->foto_utama_url, true);
                $isPlaceholder =
                isset($placeholderData['type']) &&
                $placeholderData['type'] === 'placeholder';
                } catch (\Exception $e) {
                $isPlaceholder = true;
                $placeholderData = [
                'bg_color' => 'bg-gray-200',
                'text' => 'Gambar tidak tersedia',
                ];
                }
                } elseif (!filter_var($post->foto_utama_url, FILTER_VALIDATE_URL)) {
                $isPlaceholder = true;
                $placeholderData = ['bg_color' => 'bg-gray-200', 'text' => 'Gambar tidak tersedia'];
                }
                } else {
                $isPlaceholder = true;
                $placeholderData = ['bg_color' => 'bg-gray-200', 'text' => 'Gambar tidak tersedia'];
                }
                @endphp

                @if ($isPlaceholder)
                <div
                    class="w-full h-48 {{ $placeholderData['bg_color'] ?? 'bg-gray-200' }} flex items-center justify-center flex-shrink-0">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span
                            class="text-sm font-medium text-gray-500">{{ $placeholderData['text'] ?? 'Gambar tidak tersedia' }}</span>
                    </div>
                </div>
                @else
                <a href="{{ route('posts.show', $post->slug) }}" class="block flex-shrink-0" wire:navigate>
                    <img src="{{ $post->foto_utama_url }}" alt="{{ $post->title }}"
                        class="w-full h-48 object-cover">
                </a>
                @endif

                <div class="p-4 flex flex-col flex-grow">
                    @if ($post->tag)
                    @php
                    // Generate warna unik berdasarkan nama kategori
                    $colors = [
                    'Artikel' => 'bg-blue-100 text-blue-800 hover:bg-blue-200',
                    'Dokumen' => 'bg-green-100 text-green-800 hover:bg-green-200',
                    'Berita' => 'bg-purple-100 text-purple-800 hover:bg-purple-200',
                    'Informasi' => 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200',
                    'default' => 'bg-gray-100 text-gray-800 hover:bg-gray-200',
                    ];
                    $tagClass = $colors[$post->tag->name] ?? $colors['default'];
                    @endphp
                    <div class="mb-3">
                        <a href="{{ route('posts.index', ['category' => $post->tag_id]) }}"
                            class="inline-block text-xs font-medium px-2.5 py-0.5 rounded-full transition-colors {{ $tagClass }}"
                            wire:navigate>
                            {{ $post->tag->name }}
                        </a>
                    </div>
                    @endif
                    <h2 class="text-xl font-bold mb-2 text-gray-900 leading-tight">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition-colors"
                            wire:navigate>
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3 text-sm flex-grow">
                        {{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                    </p>

                    <!-- Date and Views -->
                    <div class="text-sm text-gray-500 pt-3 border-t border-gray-100 mt-auto">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ indonesia_date($post->published_at) }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ number_format($post->views, 0, ',', '.') }}x</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Tidak ada postingan yang ditemukan.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($showPagination && $posts->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200 mt-8">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-medium">{{ $posts->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $posts->lastItem() }}</span> dari
                    <span class="font-medium">{{ $posts->total() }}</span> hasil
                </div>
                <nav aria-label="Page navigation">
                    <ul class="inline-flex -space-x-px text-sm">
                        <!-- Previous Button -->
                        @if ($posts->onFirstPage())
                        <li>
                            <span
                                class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                            </span>
                        </li>
                        @else
                        <li>
                            <button wire:click="previousPage"
                                @if ($posts->onFirstPage()) disabled @endif
                                class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:navigate>
                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                            </button>
                        </li>
                        @endif

                        <!-- Page Numbers -->
                        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                        <li>
                            <span aria-current="page"
                                class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">
                                {{ $page }}
                            </span>
                        </li>
                        @else
                        <li>
                            <button wire:click="gotoPage({{ $page }})"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 {{ $page == $posts->currentPage() ? 'bg-blue-50 text-blue-600' : '' }}"
                                wire:navigate>
                                {{ $page }}
                            </button>
                        </li>
                        @endif
                        @endforeach

                        <!-- Next Button -->
                        @if ($posts->hasMorePages())
                        <li>
                            <button wire:click="nextPage" @if (!$posts->hasMorePages()) disabled @endif
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:navigate>
                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </li>
                        @else
                        <li>
                            <span
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                            </span>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- Single Post View -->
    <div class="container mx-auto px-4 py-8">
        <article
            class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <!-- Foto Utama -->
            <div class="mb-0 rounded-t-lg overflow-hidden">
                @php
                $fotoUtama = json_decode($post->foto_utama_url, true);
                $isPlaceholder =
                is_array($fotoUtama) && isset($fotoUtama['type']) && $fotoUtama['type'] === 'placeholder';
                @endphp

                @if ($isPlaceholder && isset($fotoUtama['html']))
                {!! $fotoUtama['html'] !!}
                @elseif($isPlaceholder)
                <div
                    class="w-full h-64 flex flex-col items-center justify-center bg-gray-100 text-gray-600 p-4 text-center">
                    <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">{{ $fotoUtama['text'] ?? 'Tidak ada gambar' }}</span>
                </div>
                @else
                <img src="{{ $post->foto_utama_url }}" alt="{{ $post->title }}"
                    class="w-full h-auto max-h-96 object-cover"
                    onerror="this.onerror=null; this.parentElement.innerHTML = '<div class=\'w-full h-64 flex flex-col items-center justify-center bg-gray-100 text-gray-600 p-4 text-center\'><svg class=\'w-16 h-16 text-gray-400 mb-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><span class=\'text-sm font-medium\'>Tidak ada gambar</span></div>'">
                @endif
            </div>

            <!-- Post Header -->
            <div class="px-8 pt-8">
                <header class="mb-8 text-center">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ $post->title }}</h1>

                    <div class="flex flex-wrap justify-center items-center gap-2 text-sm text-gray-500 mb-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $post->published_at->translatedFormat('d F Y') }}
                        </span>

                        @if ($post->tags->isNotEmpty())
                        @foreach ($post->tags as $tag)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $tag->name }}
                        </span>
                        @endforeach
                        <span class="mx-1">•</span>
                        @endif
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $post->user->name ?? 'Admin' }}
                        </span>
                        @if ($post->category)
                        <span class="mx-2">•</span>
                        <a href="{{ route('posts.index', ['category' => $post->category_id]) }}"
                            class="text-blue-600 hover:text-blue-800">
                            {{ $post->category->name }}
                        </a>
                        @endif
                    </div>
                </header>
            </div>

            <!-- Post Content -->
            <div class="px-8 pb-8">
                <div class="prose max-w-none mb-6">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- Gallery Images -->
            @if ($post->postGallery && $post->postGallery->isNotEmpty())
            {{-- <div class="px-8 py-6 border-t border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Galeri Foto</h2> --}}
            <div class="px-8 py-6 border-t border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Galeri Foto</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="{
                            images: @js(
    collect($post->postGallery)->map(function ($img, $index) {
        return [
            'url' => Storage::url($img->image_path),
            'alt' => 'Galeri Gambar ' . ($index + 1),
        ];
    }),
),
                            currentIndex: 0,
                            isOpen: false,
                            init() {
                                // Handle keyboard navigation
                                document.addEventListener('keydown', (e) => {
                                    if (!this.isOpen) return;
                        
                                    if (e.key === 'Escape') {
                                        this.closeModal();
                                    } else if (e.key === 'ArrowLeft') {
                                        this.prevImage();
                                    } else if (e.key === 'ArrowRight') {
                                        this.nextImage();
                                    }
                                });
                            },
                            openModal(index) {
                                this.currentIndex = index;
                                this.isOpen = true;
                                document.body.style.overflow = 'hidden';
                            },
                            closeModal() {
                                this.isOpen = false;
                                document.body.style.overflow = 'auto';
                            },
                            nextImage() {
                                this.currentIndex = (this.currentIndex + 1) % this.images.length;
                            },
                            prevImage() {
                                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                            }
                        }">
                    <!-- Thumbnails -->
                    <template x-for="(image, index) in images" :key="index">
                        <div class="relative group overflow-hidden rounded-lg cursor-pointer"
                            @click="openModal(index)">
                            <div class="relative overflow-hidden rounded-lg">
                                <img :src="image.url" :alt="image.alt"
                                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                                    loading="lazy"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100%\' height=\'100%\' viewBox=\'0 0 400 300\'><rect width=\'100%\' height=\'100%\' fill=\'%23f3f4f6\'/><text x=\'50%\' y=\'50%\' font-family=\'sans-serif\' font-size=\'14\' text-anchor=\'middle\' dominant-baseline=\'middle\' fill=\'%239ca3af\'>Gambar tidak tersedia</text></svg>;'">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Modal -->
                    <div x-show="isOpen" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-90"
                        @click.self="closeModal()" x-cloak>
                        <div class="relative w-full max-w-4xl max-h-full">
                            <!-- Close button -->
                            <button @click="closeModal()"
                                class="absolute -top-12 right-0 text-white hover:text-gray-300 focus:outline-none z-10"
                                aria-label="Tutup">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Image -->
                            <div class="relative h-full">
                                <img :src="images[currentIndex].url" :alt="images[currentIndex].alt"
                                    class="max-h-[80vh] max-w-full mx-auto object-contain" loading="lazy">

                                <!-- Navigation Arrows -->
                                <button x-show="images.length > 1" @click.stop="prevImage()"
                                    class="absolute left-0 top-1/2 -translate-y-1/2 -ml-12 md:-ml-16 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition-all duration-200 focus:outline-none"
                                    aria-label="Gambar Sebelumnya">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                <button x-show="images.length > 1" @click.stop="nextImage()"
                                    class="absolute right-0 top-1/2 -translate-y-1/2 -mr-12 md:-mr-16 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition-all duration-200 focus:outline-none"
                                    aria-label="Gambar Selanjutnya">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Related Posts -->
            @if ($relatedPosts->count() > 0)
            <div class="px-8 py-6 border-t border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($relatedPosts as $related)
                    <div
                        class="group border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 bg-white hover:-translate-y-1">
                        <div class="h-48 bg-gray-100 overflow-hidden">
                            @php
                            $relatedFoto = $related->foto_utama_url;
                            $relatedPlaceholder = is_string($relatedFoto)
                            ? json_decode($relatedFoto, true)
                            : [];
                            $isRelatedPlaceholder =
                            is_array($relatedPlaceholder) &&
                            isset($relatedPlaceholder['type']) &&
                            $relatedPlaceholder['type'] === 'placeholder';
                            @endphp


                            @if ($isRelatedPlaceholder)
                            <div class="w-full h-full flex items-center justify-center"
                                style="background-color: {{ $relatedPlaceholder['bg_color'] ?? '#f3f4f6' }}; color: {{ $relatedPlaceholder['color'] ?? '#6b7280' }};">
                                <div class="text-center p-4">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-current" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('posts.show', $related->slug) }}" class="block h-full"
                                wire:navigate>
                                <img src="{{ $related->foto_utama_url }}"
                                    alt="{{ $related->title }}" class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gray-100\'><svg class=\'w-10 h-10 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>'">
                            </a>
                            @endif
                        </div>
                        <div class="p-4">
                            @if ($related->category)
                            <a href="{{ route('posts.index', ['category' => $related->category_id]) }}"
                                class="inline-block text-xs font-medium text-blue-600 mb-2 hover:underline"
                                wire:navigate>
                                {{ $related->category->name }}
                            </a>
                            @endif
                            <h3 class="font-bold text-lg mb-2">
                                <a href="{{ route('posts.show', $related->slug) }}" class="block"
                                    wire:navigate>
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <div class="text-sm text-gray-500">
                                {{ $related->published_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </article>
    </div>
    @endif

</div>