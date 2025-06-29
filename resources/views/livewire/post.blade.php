<div>
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
                            <div x-show="currentSlide === index" 
                                 x-transition:enter="transition ease-out duration-500"
                                 x-transition:enter-start="opacity-0" 
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-500" 
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0" 
                                 class="absolute inset-0">
                                <!-- Slide Image -->
                                <template x-if="!slide.foto_utama_url || typeof slide.foto_utama_url !== 'string' || !slide.foto_utama_url.startsWith('http')">
                                    <div x-data="{ 
                                        placeholderData: (() => { 
                                            try { 
                                                return typeof slide.foto_utama_url === 'string' ? JSON.parse(slide.foto_utama_url) : slide.foto_utama_url; 
                                            } catch(e) { 
                                                return { type: 'placeholder', bg_color: 'bg-gray-200', text: 'Gambar tidak tersedia' }; 
                                            } 
                                        })()
                                    }" class="w-full h-full flex items-center justify-center" :class="placeholderData.bg_color || 'bg-gray-200'">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-500" x-text="placeholderData.text || 'Gambar tidak tersedia'"></span>
                                        </div>
                                    </div>
                                </template>
                                <img x-show="slide.foto_utama_url && typeof slide.foto_utama_url === 'string' && slide.foto_utama_url.startsWith('http')" 
                                     :src="slide.foto_utama_url" 
                                     :alt="slide.title" 
                                     class="w-full h-full object-cover">
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                
                                <!-- Slide Content -->
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                    <!-- Category Badge -->
                                    <div class="mb-3">
                                        <span class="inline-block bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                            <span x-text="slide.tag?.name || 'Berita'"></span>
                                        </span>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h2 class="text-2xl md:text-3xl font-bold mb-3 leading-tight">
                                        <a :href="'{{ url('/posts') }}/' + slide.slug" class="hover:underline" x-text="slide.title"></a>
                                    </h2>
                                    
                                    <!-- Date and Views -->
                                    <div class="flex items-center text-sm text-gray-200">
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-clock mr-1"></i>
                                            <span x-text="new Date(slide.published_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></span>
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
                        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60 transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60 transition-colors">
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
                    <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        @php
                            $isPlaceholder = false;
                            $placeholderData = [];
                            
                            if ($post->foto_utama_url) {
                                if (is_string($post->foto_utama_url) && str_starts_with($post->foto_utama_url, '{"type"')) {
                                    try {
                                        $placeholderData = json_decode($post->foto_utama_url, true);
                                        $isPlaceholder = isset($placeholderData['type']) && $placeholderData['type'] === 'placeholder';
                                    } catch (\Exception $e) {
                                        $isPlaceholder = true;
                                        $placeholderData = ['bg_color' => 'bg-gray-200', 'text' => 'Gambar tidak tersedia'];
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

                        @if($isPlaceholder)
                            <div class="w-full h-48 {{ $placeholderData['bg_color'] ?? 'bg-gray-100' }} flex items-center justify-center">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-500">{{ $placeholderData['text'] ?? 'Gambar tidak tersedia' }}</span>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('posts.show', $post->slug) }}" class="block">
                                <img src="{{ $post->foto_utama_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            </a>
                        @endif
                        <div class="p-4">
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
                                <a href="{{ route('posts.index', ['category' => $post->tag_id]) }}"
                                    class="inline-block text-sm font-medium px-3 py-1 rounded-full mb-3 transition-colors {{ $tagClass }}">
                                    {{ $post->tag->name }}
                                </a>
                            @endif
                            <h2 class="text-xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}
                            </p>

                            <!-- Pindahkan tanggal ke sini -->
                            <div class="text-sm text-gray-500 mt-4 pt-3 border-t border-gray-100">
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
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    @else
        <!-- Single Post View -->
        <x-page-header :title="$post->title" />
        <div class="container mx-auto px-4 py-8">
            <article class="max-w-4xl mx-auto">
                <!-- Foto Utama -->
                <div class="mb-8 rounded-lg overflow-hidden">
                    @php
                        $fotoUtama = json_decode($post->foto_utama_url, true);
                        $isPlaceholder = is_array($fotoUtama) && isset($fotoUtama['type']) && $fotoUtama['type'] === 'placeholder';
                    @endphp
                    
                    @if($isPlaceholder && isset($fotoUtama['html']))
                        {!! $fotoUtama['html'] !!}
                    @elseif($isPlaceholder)
                        <div class="w-full h-64 flex flex-col items-center justify-center bg-gray-100 text-gray-600 p-4 text-center">
                            <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $fotoUtama['text'] ?? 'Tidak ada gambar' }}</span>
                        </div>
                    @else
                        <img src="{{ $post->foto_utama_url }}" 
                             alt="{{ $post->title }}"
                             class="w-full h-auto max-h-96 object-cover"
                             onerror="this.onerror=null; this.parentElement.innerHTML = '<div class=\'w-full h-64 flex flex-col items-center justify-center bg-gray-100 text-gray-600 p-4 text-center\'><svg class=\'w-16 h-16 text-gray-400 mb-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><span class=\'text-sm font-medium\'>Tidak ada gambar</span></div>'">
                    @endif
                </div>

                <!-- Post Header -->
                <header class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $post->published_at->translatedFormat('d F Y') }}
                        </span>
                        <span class="mx-2">•</span>
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

                <!-- Post Content -->
                <div class="prose max-w-none mb-12">
                    {!! $post->content !!}
                </div>

                <!-- Related Posts -->
                @if ($relatedPosts->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Baca Juga</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($relatedPosts as $related)
                                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white">
                                    @php
                                        $relatedFoto = $related->foto_utama_url;
                                        $relatedPlaceholder = is_string($relatedFoto) ? json_decode($relatedFoto, true) : [];
                                        $isRelatedPlaceholder = is_array($relatedPlaceholder) && isset($relatedPlaceholder['type']) && $relatedPlaceholder['type'] === 'placeholder';
                                    @endphp
                                    
                                    <div class="w-full h-48 bg-gray-100 overflow-hidden">
                                        @if($isRelatedPlaceholder)
                                            <div class="w-full h-full flex items-center justify-center" style="background-color: {{ $relatedPlaceholder['bg_color'] ?? '#f3f4f6' }}; color: {{ $relatedPlaceholder['color'] ?? '#6b7280' }};">
                                                <div class="text-center p-4">
                                                    <svg class="w-10 h-10 mx-auto mb-2 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ route('posts.show', $related->slug) }}" class="block h-full">
                                                <img src="{{ $related->foto_utama_url }}" 
                                                     alt="{{ $related->title }}" 
                                                     class="w-full h-full object-cover"
                                                     onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gray-100\'><svg class=\'w-10 h-10 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>'">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        @if ($related->category)
                                            <a href="{{ route('posts.index', ['category' => $related->category_id]) }}"
                                                class="inline-block text-xs font-medium text-blue-600 mb-2 hover:underline">
                                                {{ $related->category->name }}
                                            </a>
                                        @endif
                                        <h3 class="font-bold text-lg mb-2">
                                            <a href="{{ route('posts.show', $related->slug) }}"
                                                class="hover:text-blue-600">
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
