<div>
    @use('Illuminate\Support\Facades\Storage')

    @push('title', $pageTitle)
    @push('meta')
        <meta name="description" content="{{ $pageDescription }}">
    @endpush

    <div class="space-y-8">
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
                                                    <i class="bi bi-eye me-1" style="display: inline-block;"></i>
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
                                Lihat Semua Berita <i class="bi bi-arrow-right-short ms-1"
                                    style="display: inline-block;"></i>
                            </a>
                        </div>


                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-3 ps-lg-4">
                        <!-- Hanya menampilkan banner di sidebar -->
                        <livewire:banner />
                    </div>
                </div>
            </div>
        </section>
        <!-- Informasi & Agenda -->
        <section class="w-full bg-white py-8 px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl mx-auto">
                <!-- Kolom Informasi -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <h3
                        class="text-center text-blue-800 text-lg font-semibold py-3 border-b border-blue-200 bg-blue-50">
                        <i class="fas fa-info-circle text-blue-600 mr-2" style="display: inline-block;"></i>
                        Informasi Terbaru
                    </h3>
                    <div class="p-6">
                        <livewire:informasi />
                    </div>
                </div>

                <!-- Kolom Agenda -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <h3
                        class="text-center text-green-800 text-lg font-semibold py-3 border-b border-green-200 bg-green-50">
                        <i class="far fa-calendar-alt text-green-600 mr-2" style="display: inline-block;"></i>
                        Agenda Kegiatan
                    </h3>
                    <div class="p-6">
                        <livewire:agenda-kegiatan />
                    </div>
                </div>
            </div>
        </section>

        <!-- Dokumen Terbaru Section -->
        <section id="dokumen-terbaru" class="py-8 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Dokumen Terbaru</h2>
                    <p class="text-gray-600">Akses dokumen-dokumen penting terbaru</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($dokumens as $dokumen)
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="relative">
                                @if ($dokumen->cover)
                                    <img src="{{ asset('storage/' . $dokumen->cover) }}"
                                        class="w-full h-48 object-cover" alt="{{ $dokumen->nama_dokumen }}">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="bi bi-file-earmark-text text-gray-400 text-5xl"
                                            style="display: inline-block;"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $dokumen->nama_dokumen }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($dokumen->deskripsi, 100) }}</p>

                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <span><i class="bi bi-calendar me-1" style="display: inline-block;"></i>
                                        {{ $dokumen->tahun_terbit }}</span>
                                </div>

                                <div class="flex justify-between items-center mb-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="bi bi-eye me-1" style="display: inline-block;"></i>
                                        {{ number_format($dokumen->views) }} dilihat
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="bi bi-download me-1" style="display: inline-block;"></i>
                                        {{ number_format($dokumen->downloads) }} unduhan
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                                        onclick="Livewire.dispatch('incrementViews', { dokumenId: {{ $dokumen->id }} })"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="bi bi-eye me-1" style="display: inline-block;"></i> Lihat
                                    </a>
                                    <a href="{{ asset('storage/' . $dokumen->file) }}" download
                                        onclick="Livewire.dispatch('incrementDownloads', { dokumenId: {{ $dokumen->id }} })"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="bi bi-download me-1" style="display: inline-block;"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8">
                            <div class="text-gray-500">
                                <i class="bi bi-file-earmark-text text-5xl mb-3 block"
                                    style="display: inline-block;"></i>
                                <p>Belum ada dokumen yang tersedia</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('dokumen') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Lihat Semua Dokumen <i class="bi bi-arrow-right ms-2" style="display: inline-block;"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Section External Links -->
        <section id="external-links" class="external-links-section section">
            <div class="mt-8">
                @livewire('external-links', ['limit' => 8])
            </div>
        </section>
    </div>
</div>
