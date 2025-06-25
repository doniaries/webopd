<div>
    @use('Illuminate\Support\Facades\Storage')

    @push('title', $pageTitle)
    @push('meta')
        <meta name="description" content="{{ $pageDescription }}">
    @endpush

    <div>
        <!-- Hero Slider Section -->
        @if (empty($sliders) || count($sliders) === 0)
            @livewire('slider', ['sliders' => $banners, 'pengaturan' => $pengaturan ?? null, 'usePostsAsSliders' => false])
        @else
            @livewire('slider', ['sliders' => $sliders, 'pengaturan' => $pengaturan ?? null, 'usePostsAsSliders' => true])
        @endif
        <!-- End Hero Slider -->

        <!-- Berita & Informasi Section -->
        <section id="berita-informasi" class="features" style="margin: 1.5rem 0 0 0; padding: 0;">
            <div class="container-fluid px-4">
                <div class="row g-4">
                    <!-- Berita Terbaru Column -->
                    <div class="col-lg-9 pe-lg-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="border-start border-3 border-danger me-2" style="height: 24px;"></div>
                            <h2 class="h4 fw-bold mb-0">Berita Terkini</h2>
                        </div>

                        <div class="row g-9">
                            @php
                                try {
                                    $recentPosts = App\Models\Post::query()
                                        ->where('status', 'published')
                                        ->where('published_at', '<=', now())
                                        ->with(['tags', 'user'])
                                        ->latest('published_at')
                                        ->take(6)
                                        ->get();
                                } catch (\Exception $e) {
                                    $recentPosts = collect();
                                }
                            @endphp

                            @foreach ($recentPosts as $post)
                                <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4">
                                    <a href="{{ route('berita.show', $post->slug) }}"
                                        class="text-decoration-none d-block h-100">
                                        <div class="card h-100 border-1 overflow-hidden mx-auto"
                                            style="transition: transform 0.2s ease, box-shadow 0.2s ease; width: 100%;">
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <span
                                                    class="badge bg-white text-dark border border-light-subtle shadow-sm">
                                                    <i class="bi bi-eye me-1"></i>
                                                    {{ $post->views ?? 0 }}
                                                </span>
                                            </div>
                                            <!-- Gambar Utama -->
                                            <div class="position-relative" style="padding-top: 56.25%;">
                                                @php
                                                    $isPlaceholder = false;
                                                    $placeholderData = [];

                                                    if ($post->foto_utama_url) {
                                                        if (
                                                            is_string($post->foto_utama_url) &&
                                                            str_starts_with($post->foto_utama_url, '{"type"')
                                                        ) {
                                                            try {
                                                                $placeholderData = json_decode(
                                                                    $post->foto_utama_url,
                                                                    true,
                                                                );
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
                                                        } elseif (
                                                            !filter_var($post->foto_utama_url, FILTER_VALIDATE_URL)
                                                        ) {
                                                            $isPlaceholder = true;
                                                            $placeholderData = [
                                                                'bg_color' => 'bg-gray-200',
                                                                'text' => 'Gambar tidak tersedia',
                                                            ];
                                                        }
                                                    } else {
                                                        $isPlaceholder = true;
                                                        $placeholderData = [
                                                            'bg_color' => 'bg-gray-200',
                                                            'text' => 'Gambar tidak tersedia',
                                                        ];
                                                    }
                                                @endphp

                                                @if ($isPlaceholder)
                                                    <div
                                                        class="position-absolute top-0 start-0 w-100 h-100 flex items-center justify-center {{ $placeholderData['bg_color'] ?? 'bg-gray-100' }}">
                                                        <div class="text-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-12 w-12 mx-auto mb-2 text-gray-400"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span
                                                                class="text-sm font-medium text-gray-500">{{ $placeholderData['text'] ?? 'Gambar tidak tersedia' }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ $post->foto_utama_url }}"
                                                        class="position-absolute top-0 start-0 w-100 h-100 card-img-top"
                                                        style="object-fit: cover;" alt="{{ $post->title }}">
                                                @endif

                                                <div
                                                    class="position-absolute bottom-0 start-0 p-2 bg-primary text-white small">
                                                    {{ $post->tags->first()->name ?? 'Berita' }}
                                                </div>
                                            </div>
                                            <!-- Konten Teks -->
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title mb-2 text-dark text-center"
                                                    style="font-size: 1rem;">
                                                    {{ Str::limit($post->title, 80) }}
                                                </h5>
                                                <div class="d-flex align-items-center text-muted small mb-3">
                                                    <span class="d-flex align-items-center me-3">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        {{ $post->created_at->format('d M Y') }}
                                                    </span>
                                                    <span class="d-flex align-items-center">
                                                        <i class="bi bi-person-fill me-1"></i>
                                                        {{ $post->user->name ?? 'Admin' }}
                                                    </span>
                                                </div>
                                                <p class="card-text small text-muted mb-2 text-start">
                                                    {{ Str::limit(strip_tags($post->content), 100) }}
                                                </p>
                                                <div
                                                    class="d-flex align-items-center mt-auto pt-2 border-top justify-content-between">
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="bi bi-eye me-1"></i>
                                                        <span class="text-end">{{ $post->views ?? 0 }} Dilihat</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">
                                Lihat Semua Berita <i class="bi bi-arrow-right-short ms-1"></i>
                            </a>
                        </div>

                        <!-- Berita Populer Section (moved here) -->
                        <section id="informasi-populer" class="py-5 bg-white">
                            <div class="container" data-aos="fade-up">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="border-start border-3 border-primary me-2" style="height: 24px;">
                                        </div>
                                        <h2 class="h4 fw-bold mb-0">Berita Populer</h2>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-secondary me-2 scroll-left"
                                            type="button">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary scroll-right" type="button">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <div class="scroll-container"
                                        style="overflow-x: auto; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none;">
                                        <div class="d-flex flex-nowrap pb-4" style="width: max-content;">
                                            @php
                                                try {
                                                    $popularPosts = App\Models\Post::query()
                                                        ->where('status', 'published')
                                                        ->where('published_at', '<=', now())
                                                        ->with([
                                                            'categories' => function ($q) {
                                                                $q->where('is_active', true);
                                                            },
                                                            'user',
                                                        ])
                                                        ->orderBy('views', 'desc')
                                                        ->take(8)
                                                        ->get();
                                                } catch (\Exception $e) {
                                                    $popularPosts = collect();
                                                }
                                            @endphp

                                            @foreach ($popularPosts as $post)
                                                <div class="me-4" style="width: 280px; flex: 0 0 auto;">
                                                    <div class="card h-100 border-0 shadow-sm">
                                                        <div class="position-relative"
                                                            style="height: 160px; overflow: hidden;">
                                                            @php
                                                                $isPlaceholder = false;
                                                                $placeholderData = [];

                                                                if ($post->foto_utama_url) {
                                                                    if (
                                                                        is_string($post->foto_utama_url) &&
                                                                        str_starts_with(
                                                                            $post->foto_utama_url,
                                                                            '{"type"',
                                                                        )
                                                                    ) {
                                                                        try {
                                                                            $placeholderData = json_decode(
                                                                                $post->foto_utama_url,
                                                                                true,
                                                                            );
                                                                            $isPlaceholder =
                                                                                isset($placeholderData['type']) &&
                                                                                $placeholderData['type'] ===
                                                                                    'placeholder';
                                                                        } catch (\Exception $e) {
                                                                            $isPlaceholder = true;
                                                                            $placeholderData = [
                                                                                'bg_color' => 'bg-gray-200',
                                                                                'text' => 'Gambar tidak tersedia',
                                                                            ];
                                                                        }
                                                                    } elseif (
                                                                        !filter_var(
                                                                            $post->foto_utama_url,
                                                                            FILTER_VALIDATE_URL,
                                                                        )
                                                                    ) {
                                                                        $isPlaceholder = true;
                                                                        $placeholderData = [
                                                                            'bg_color' => 'bg-gray-200',
                                                                            'text' => 'Gambar tidak tersedia',
                                                                        ];
                                                                    }
                                                                } else {
                                                                    $isPlaceholder = true;
                                                                    $placeholderData = [
                                                                        'bg_color' => 'bg-gray-200',
                                                                        'text' => 'Gambar tidak tersedia',
                                                                    ];
                                                                }
                                                            @endphp

                                                            @if ($isPlaceholder)
                                                                <div
                                                                    class="h-100 w-100 flex items-center justify-center {{ $placeholderData['bg_color'] ?? 'bg-gray-100' }}">
                                                                    <div class="text-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-8 w-8 mx-auto mb-2 text-gray-400"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="1"
                                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                        </svg>
                                                                        <span
                                                                            class="text-xs font-medium text-gray-500">{{ $placeholderData['text'] ?? 'Gambar tidak tersedia' }}</span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <img src="{{ $post->foto_utama_url }}"
                                                                    class="card-img-top h-100 w-100"
                                                                    style="object-fit: cover;"
                                                                    alt="{{ $post->title }}">
                                                            @endif
                                                            <div class="position-absolute top-0 end-0 m-2">
                                                                <span class="badge bg-danger">
                                                                    <i class="bi bi-fire me-1"></i> Hot
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="badge bg-primary me-2">
                                                                    {{ $post->categories->first()->name ?? 'Berita' }}
                                                                </span>
                                                                <small class="text-muted">
                                                                    <i class="bi bi-eye me-1"></i>
                                                                    {{ number_format($post->views ?? 0) }}
                                                                </small>
                                                            </div>
                                                            <h5 class="card-title" style="font-size: 1rem;">
                                                                <a href="{{ route('berita.show', $post->slug) }}"
                                                                    class="text-dark text-decoration-none">
                                                                    {{ Str::limit($post->title, 50) }}
                                                                </a>
                                                            </h5>
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mt-3">
                                                                <small class="text-muted">
                                                                    <i class="bi bi-calendar3-fill me-1"></i>
                                                                    {{ indonesia_date($post->published_at) }}
                                                                </small>
                                                                <a href="{{ route('berita.show', $post->slug) }}"
                                                                    class="text-primary small">
                                                                    Baca <i class="bi bi-arrow-right-short"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if ($popularPosts->isEmpty())
                                                <div class="col-12 text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="bi bi-newspaper display-6 d-block mb-3"></i>
                                                        Belum ada berita populer
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Informasi Column with Banner -->
                    <div class="col-lg-3 ps-lg-4">
                        <!-- Banner Slider Section -->
                        <div class="mb-6">
                            @livewire('banner')
                        </div>

                        <!-- Informasi Terbaru Card -->
                        @livewire('informasi')

                        <!-- Agenda Section -->
                        @livewire('agenda-kegiatan')
                    </div>
                </div>
            </div>

        </section>

        <!-- Section External Links -->
        @livewire('external-links', ['limit' => 8])
    </div>
</div>
