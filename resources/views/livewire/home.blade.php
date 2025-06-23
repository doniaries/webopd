<div>
    @use('Illuminate\Support\Facades\Storage')

    @push('title', $pageTitle)
    @push('meta')
        <meta name="description" content="{{ $pageDescription }}">
    @endpush

    <main id="main">
        <!-- Hero Slider Section -->
        @livewire('slider', ['sliders' => $sliders, 'pengaturan' => $pengaturan ?? null, 'usePostsAsSliders' => true])
        <!-- End Hero Slider -->
        <!-- Berita & Informasi Section -->
        <section id="berita-informasi" class="features" style="margin: 1.5rem 0 0 0; padding: 0;">
            <div class="container-lg px-0">
                <div class="row g-4">
                    <!-- Berita Terbaru Column -->
                    <div class="col-lg-8 pe-lg-4">
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
                                                <img src="{{ $post->foto_utama_url }}"
                                                    class="position-absolute top-0 start-0 w-100 h-100 card-img-top"
                                                    style="object-fit: cover;" alt="{{ $post->title }}">
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
                                                            <img src="{{ $post->foto_utama_url ?? asset('images/placeholder.jpg') }}"
                                                                class="card-img-top h-100 w-100"
                                                                style="object-fit: cover;" alt="{{ $post->title }}">
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

                    <!-- Informasi Column -->
                    <div class="col-lg-4 ps-lg-4">
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                            <div class="border-b border-gray-200 bg-white px-4 py-3">
                                <h5 class="text-base font-semibold text-gray-800 flex items-center">
                                    <span class="w-1 h-5 bg-blue-600 rounded-full mr-2"></span>
                                    <i class="bi bi-megaphone text-blue-600 mr-2"></i>
                                    Informasi Terbaru
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @php
                                    try {
                                        $informasi = App\Models\Informasi::query()
                                            ->where('published_at', '<=', now())
                                            ->latest('published_at')
                                            ->take(5)
                                            ->get(['id', 'judul', 'slug', 'isi', 'published_at']);
                                    } catch (\Exception $e) {
                                        $informasi = collect();
                                    }
                                @endphp

                                @if ($informasi->count() > 0)
                                    <div class="divide-y divide-gray-100">
                                        @php
                                            $bgColors = [
                                                'bg-blue-50 hover:bg-blue-50 border-blue-200',
                                                'bg-purple-50 hover:bg-purple-50 border-purple-200',
                                                'bg-amber-50 hover:bg-amber-50 border-amber-200',
                                                'bg-emerald-50 hover:bg-emerald-50 border-emerald-200',
                                                'bg-rose-50 hover:bg-rose-50 border-rose-200',
                                            ];
                                            $bgColorIndex = 0;
                                        @endphp
                                        @foreach ($informasi as $item)
                                            @php
                                                $bgClass = $bgColors[$bgColorIndex % count($bgColors)];
                                                $bgColorIndex++;
                                            @endphp
                                            <a href="{{ route('informasi.show', $item->slug) }}"
                                                class="block px-4 py-3 transition-all duration-300 border-l-4 {{ $bgClass }} group informasi-item">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="p-2.5 rounded-lg text-blue-600 transition-all duration-300 group-hover:scale-105 {{ str_replace('hover:bg-', 'bg-', str_replace('50', '100', $bgClass)) }}">
                                                            <i class="bi bi-megaphone-fill text-lg"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h6
                                                            class="text-sm font-semibold text-gray-900 mb-1 line-clamp-1">
                                                            {{ $item->judul }}
                                                        </h6>
                                                        @if ($item->isi)
                                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                                                {{ Str::limit(strip_tags($item->isi), 100) }}
                                                            </p>
                                                        @endif
                                                        <div
                                                            class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                                                            <div class="flex items-center">
                                                                <i class="bi bi-calendar3-fill mr-1"></i>
                                                                <span>{{ $item->published_at->diffForHumans() }}</span>
                                                            </div>
                                                            <span>•</span>
                                                            <div class="flex items-center">
                                                                <i class="bi bi-clock-fill mr-1"></i>
                                                                <span>{{ $item->published_at->format('d M Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="text-gray-400 group-hover:text-blue-500 transition-colors">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center p-6">
                                        <div
                                            class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-500 mb-3">
                                            <i class="bi bi-info-circle-fill text-2xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">Tidak ada informasi terbaru</p>
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right border-t border-gray-100">
                                <a href="{{ route('informasi.index') }}"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                    <span>Lihat Semua Informasi</span>
                                    <i class="bi bi-arrow-right ml-1.5"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Agenda Section -->
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6 transition-all duration-300 hover:shadow-md">
                            <div class="border-b border-gray-200 bg-white px-4 py-3">
                                <h5 class="text-base font-semibold text-gray-800 flex items-center">
                                    <span class="w-1 h-5 bg-green-600 rounded-full mr-2"></span>
                                    <i class="bi bi-calendar2-check-fill text-green-600 mr-2"></i>
                                    Agenda Mendatang
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @php
                                    try {
                                        $agenda = App\Models\AgendaKegiatan::query()
                                            ->where('dari_tanggal', '>=', now())
                                            ->orWhere('sampai_tanggal', '>=', now())
                                            ->orderBy('dari_tanggal')
                                            ->take(3)
                                            ->get();
                                        \Log::info('Agenda data:', $agenda->toArray()); // Log data untuk debugging
                                    } catch (\Exception $e) {
                                        \Log::error('Error fetching agenda: ' . $e->getMessage());
                                        $agenda = collect();
                                    }
                                @endphp

                                @if ($agenda->count() > 0)
                                    <div class="divide-y divide-gray-100">
                                        @foreach ($agenda as $item)
                                            <a href="{{ route('agenda.show', $item->id) }}"
                                                class="block px-4 py-3 hover:bg-gray-50 transition-all duration-300 group informasi-item">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="flex flex-col items-center justify-center w-14 h-14 rounded-lg border-2 border-green-200 bg-white text-center overflow-hidden">
                                                            <div
                                                                class="w-full bg-green-600 text-white text-xs font-bold py-0.5">
                                                                {{ strtoupper(indonesia_date($item->dari_tanggal, false, 'M')) }}
                                                            </div>
                                                            <div
                                                                class="text-gray-800 text-xl font-extrabold leading-tight py-1">
                                                                {{ indonesia_date($item->dari_tanggal, false, 'd') }}
                                                            </div>
                                                            <div
                                                                class="text-xs text-gray-500 font-medium w-full border-t border-gray-100">
                                                                {{ $item->dari_tanggal->format('Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h6
                                                            class="text-sm font-semibold text-gray-900 mb-1 line-clamp-1">
                                                            {{ $item->nama_agenda }}
                                                        </h6>

                                                        @if ($item->uraian_agenda)
                                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                                                {{ Str::limit(strip_tags($item->uraian_agenda), 100) }}
                                                            </p>
                                                        @endif
                                                        @if ($item->penyelenggara)
                                                            <div
                                                                class="flex items-start text-xs bg-green-50 text-green-800 rounded px-2 py-1 mb-1 w-full">
                                                                <i
                                                                    class="bi bi-building mr-1.5 mt-0.5 flex-shrink-0"></i>
                                                                <span
                                                                    class="break-words">{{ $item->nama_penyelenggara }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="mt-2">
                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">

                                                                <div class="bg-blue-50 rounded p-2">
                                                                    <div
                                                                        class="flex items-center text-xs text-blue-700">
                                                                        <i class="bi bi-calendar3-fill mr-1.5"></i>
                                                                        <span>
                                                                            @if ($item->sampai_tanggal && $item->dari_tanggal->format('Y-m-d') !== $item->sampai_tanggal->format('Y-m-d'))
                                                                                {{ $item->dari_tanggal->translatedFormat('d M Y') }}
                                                                                -
                                                                                {{ $item->sampai_tanggal->translatedFormat('d M Y') }}
                                                                            @else
                                                                                {{ $item->dari_tanggal->translatedFormat('d M Y') }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                @if ($item->waktu_mulai && $item->waktu_selesai)
                                                                    <div class="bg-green-50 rounded p-2">
                                                                        <div
                                                                            class="flex items-center text-xs text-green-700">
                                                                            <i class="bi bi-clock-fill mr-1.5"></i>
                                                                            <span>{{ $item->waktu_mulai ? $item->waktu_mulai->format('H:i') : '' }}
                                                                                -
                                                                                {{ $item->waktu_selesai ? $item->waktu_selesai->format('H:i') : '' }}
                                                                                WIB</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            @if ($item->tempat)
                                                                <div class="mt-2">
                                                                    <div
                                                                        class="flex items-start text-xs text-gray-600 bg-gray-50 rounded p-2">
                                                                        <i
                                                                            class="bi bi-geo-alt-fill text-gray-500 mr-1.5 mt-0.5"></i>
                                                                        <span
                                                                            class="break-words">{{ $item->tempat }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="text-gray-400 group-hover:text-green-500 transition-colors self-center">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center p-6">
                                        <div
                                            class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-50 text-green-500 mb-3">
                                            <i class="bi bi-calendar2-x-fill text-2xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">Tidak ada agenda mendatang</p>
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right border-t border-gray-100">
                                <a href="{{ route('agenda.index') }}"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
                                    <span>Lihat Semua Agenda</span>
                                    <i class="bi bi-arrow-right ml-1.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>

@push('styles')
    <style>
        /* Card Styles */
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
            border-color: rgba(13, 110, 253, 0.2);
        }

        .card-img-top {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-title a {
            transition: color 0.3s ease;
        }

        .card:hover .card-title a {
            color: #0d6efd !important;
        }

        /* Informasi Item Hover Effect */
        .informasi-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0.5rem;
            border: 1px solid transparent;
        }

        .informasi-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            border-color: #93c5fd;
            background-color: #f8fafc !important;
        }

        .informasi-item .flex-shrink-0 div {
            transition: all 0.3s ease;
        }

        .informasi-item:hover .flex-shrink-0 div {
            transform: scale(1.1);
            background-color: #3b82f6 !important;
            color: white;
        }

        .informasi-item .bi-chevron-right {
            transition: all 0.3s ease;
        }

        .informasi-item:hover .bi-chevron-right {
            transform: translateX(3px);
            color: #3b82f6 !important;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.35rem 0.65rem;
            border-radius: 0.375rem;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
        }

        .card {
            cursor: pointer;
        }

        .card-title {
            transition: color 0.3s ease;
        }

        .card:hover .card-title {
            color: #0d6efd !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scrolling for news container
            initHorizontalScroll('.scroll-container', '.scroll-left', '.scroll-right');

            // Initialize scrolling for video container
            initHorizontalScroll('.video-scroll-container');

            // Initialize video modals
            initVideoModals();

            function initHorizontalScroll(containerSelector, prevBtnSelector = null, nextBtnSelector = null) {
                const container = document.querySelector(containerSelector);
                if (!container) return;

                const scrollAmount = 300; // Adjust this value to control scroll distance
                let prevBtn, nextBtn;

                if (prevBtnSelector && nextBtnSelector) {
                    prevBtn = document.querySelector(prevBtnSelector);
                    nextBtn = document.querySelector(nextBtnSelector);
                }


                if (prevBtn && nextBtn) {
                    // Navigation with buttons
                    prevBtn.addEventListener('click', function() {
                        container.scrollBy({
                            left: -scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    nextBtn.addEventListener('click', function() {
                        container.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    // Hide/show buttons based on scroll position
                    const updateButtonVisibility = () => {
                        const {
                            scrollLeft,
                            scrollWidth,
                            clientWidth
                        } = container;
                        prevBtn.style.visibility = scrollLeft > 0 ? 'visible' : 'hidden';
                        nextBtn.style.visibility = scrollLeft < (scrollWidth - clientWidth - 1) ? 'visible' :
                            'hidden';
                    };

                    container.addEventListener('scroll', updateButtonVisibility);
                    window.addEventListener('resize', updateButtonVisibility);
                    updateButtonVisibility(); // Initial check
                } else {
                    // Touch/swipe support for mobile
                    let isDown = false;
                    let startX;
                    let scrollLeft;

                    container.addEventListener('mousedown', (e) => {
                        isDown = true;
                        startX = e.pageX - container.offsetLeft;
                        scrollLeft = container.scrollLeft;
                        container.style.cursor = 'grabbing';
                        container.style.userSelect = 'none';
                    });

                    container.addEventListener('mouseleave', () => {
                        isDown = false;
                        container.style.cursor = 'grab';
                    });

                    container.addEventListener('mouseup', () => {
                        isDown = false;
                        container.style.cursor = 'grab';
                    });

                    container.addEventListener('mousemove', (e) => {
                        if (!isDown) return;
                        e.preventDefault();
                        const x = e.pageX - container.offsetLeft;
                        const walk = (x - startX) * 2; // Scroll-fast
                        container.scrollLeft = scrollLeft - walk;
                    });
                }
            }


            function initVideoModals() {
                // This function can be expanded to handle video modal initialization
                // when a video thumbnail is clicked
                const videoPlayButtons = document.querySelectorAll('.video-play-button');

                videoPlayButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const videoUrl = this.getAttribute('data-video');
                        // Here you can implement a modal to play the video
                        // For example, using Bootstrap's modal or another lightbox solution
                        console.log('Play video:', videoUrl);
                    });
                });
            }
        });
    </script>
@endpush
</div>
