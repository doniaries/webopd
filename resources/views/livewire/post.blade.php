@if ($view === 'index')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">{{ $pageTitle }}</h1>

        <!-- Search and Filter -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Cari & Filter</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari judul atau isi postingan..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out"
                        aria-label="Cari postingan">
                </div>

                <!-- Category Filter -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <select wire:model.live="category"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                    </div>

                    <!-- Sort Filter -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4h13M3 8h9m-9 4h6m4-4h6m-6 4h6m-6 4h6m4-8h4m-4 4h4m-4 4h4" />
                            </svg>
                        </span>
                        <select wire:model.live="sort"
                            class="block w-full pl-10 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="popular">Paling Banyak Dilihat</option>
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <button type="button" wire:click="resetFilters"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filter
                    </button>
                </div>


            </div>

            <!-- Jumlah Berita dan Filter -->
            <div class="flex justify-between items-center mb-6">
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

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 {{ $layout === 'grid' ? 'md:grid-cols-2 lg:grid-cols-3' : '' }} gap-6">
                @forelse($posts as $post)
                    <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        @if ($post->foto_utama_url)
                            <a href="{{ route('posts.show', $post->slug) }}" class="block">
                                <img src="{{ $post->foto_utama_url }}" alt="{{ $post->title }}"
                                    class="w-full h-48 object-cover">
                            </a>
                        @else
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
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
                                        <span>{{ $post->published_at->translatedFormat('d M Y') }}</span>
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
        <div class="container mx-auto px-4 py-8">
            <article class="max-w-4xl mx-auto">
                <!-- Foto Utama -->
                @if ($post->foto_utama)
                    <div class="mb-8 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/foto-utama/' . $post->foto_utama) }}" alt="{{ $post->title }}"
                            class="w-full h-auto max-h-96 object-cover">
                    </div>
                @endif

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
                                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    @if ($related->foto_utama)
                                        <a href="{{ route('posts.show', $related->slug) }}" class="block">
                                            <img src="{{ asset('storage/foto-utama/' . $related->foto_utama) }}"
                                                alt="{{ $related->title }}" class="w-full h-48 object-cover">
                                        </a>
                                    @endif
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
