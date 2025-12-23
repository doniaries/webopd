<div>
    @use('Illuminate\Support\Facades\Storage')

    @push('title', $pageTitle)
    @push('meta')
    <meta name="description" content="{{ $pageDescription }}">
    @endpush


    <div class="bg-white" style="margin-top: 0 !important; padding-top: 0 !important;">
        <livewire:slider />
        <!-- Berita Section -->
        <section id="berita-informasi" class="features pb-8 border-b border-gray-200 bg-white"
            style="margin: 1.5rem 0 0 0; padding: 2rem 0;">
            <div class="container-fluid px-4">
                <div class="row g-4 flex-row-reverse">
                    <!-- Berita Terbaru Column (Right Side 8 cols) -->
                    <div class="col-lg-8 ps-lg-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="border-start border-3 border-success me-2" style="height: 24px;"></div>
                            <h2 class="h4 fw-bold mb-0 text-success">Berita Terkini</h2>
                        </div>

                        <div class="row g-4">
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
                                <div class="col-12 col-md-6 mb-4">
                                    <a href="{{ route('berita.show', $post->slug) }}"
                                        class="text-decoration-none d-block h-100">
                                        <div class="card h-100 border-0 shadow-sm overflow-hidden mx-auto modern-card"
                                            style="width: 100%;">

                                            <!-- Gambar Utama -->
                                            <div class="position-relative" style="padding-top: 60%;">
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
                                                <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden">
                                                    <img src="{{ $post->foto_utama_url }}"
                                                        class="w-100 h-100 card-img-top hover-zoom"
                                                        style="object-fit: cover; transition: transform 0.5s ease;"
                                                        alt="{{ $post->title }}">
                                                </div>
                                                @endif

                                                <div
                                                    class="position-absolute bottom-0 start-0 p-2 bg-success text-white small rounded-end">
                                                    {{ $post->tags->first()->name ?? 'Berita' }}
                                                </div>
                                            </div>
                                            <!-- Konten Teks -->
                                            <div class="card-body d-flex flex-column p-4">
                                                <h5 class="card-title mb-3 fw-bold text-dark"
                                                    style="font-size: 1.1rem; line-height: 1.5;">
                                                    {{ Str::limit($post->title, 80) }}
                                                </h5>
                                                <p class="card-text small text-muted mb-3 flex-grow-1">
                                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        {{ $post->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div class="d-flex align-items-center text-primary small fw-semibold">
                                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('berita.index') }}" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm">
                                Lihat Semua Berita <i class="bi bi-arrow-right-short ms-1"></i>
                            </a>
                        </div>


                    </div>

                    <!-- Sidebar (Left Side 4 cols) -->
                    <div class="col-lg-4 pe-lg-4 border-end border-light">
                        <!-- Banner Section -->
                        <div class="mb-5 sticky-top" style="top: 100px; z-index: 1;">
                            <div class="bg-light p-4 rounded-3 mb-4 border border-light">
                                <h5 class="fw-bold mb-3 text-secondary">Statistik & Banner</h5>
                                @livewire('banner')
                                <div class="mt-4">
                                    <livewire:visitor-stats />
                                </div>
                            </div>
                        </div>
                        <!-- End Banner Section -->
                    </div>

                </div>
            </div>
        </section>

        <!-- Agenda & Pengumuman Section -->
        <section id="agenda-pengumuman" class="bg-blue-50 py-6">
            <div class="container-fluid px-4">
                <div class="row g-4">
                    <!-- Agenda Section -->
                    <div class="col-lg-8">
                        <div class="bg-white rounded-lg shadow-sm p-4 h-100">
                            <div class="d-flex align-items-center mb-4">
                                <div class="border-start border-3 border-primary me-2" style="height: 24px;"></div>
                                <h2 class="h5 fw-bold mb-0">Agenda Kegiatan</h2>
                                <a href="{{ route('agenda.index') }}" class="ms-auto small text-decoration-none">
                                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                            <div class="table-responsive" style="overflow-x: hidden;">
                                <table class="table table-hover table-sm align-middle mb-0 agenda-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-nowrap">Tanggal</th>
                                            <th class="text-nowrap">Kegiatan</th>
                                            <th class="text-nowrap text-center">Status</th>
                                            <th class="text-nowrap text-center">Waktu</th>
                                            <th class="text-nowrap text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $agendas = \App\Models\AgendaKegiatan::query()
                                        ->where('dari_tanggal', '>=', now()->toDateString())
                                        ->orderBy('dari_tanggal')
                                        ->orderBy('waktu_mulai')
                                        ->take(7)
                                        ->get();
                                        @endphp
                                        @forelse($agendas as $agenda)
                                        <tr>
                                            <td class="text-nowrap">
                                                <div class="fw-medium">
                                                    {{ \Carbon\Carbon::parse($agenda->dari_tanggal)->translatedFormat('d M Y') }}
                                                    @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                    -
                                                    {{ \Carbon\Carbon::parse($agenda->sampai_tanggal)->translatedFormat('d M Y') }}
                                                    @endif
                                                </div>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($agenda->dari_tanggal)->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-medium text-truncate" style="max-width: 300px;">
                                                    {{ $agenda->nama_agenda }}
                                                </div>
                                                <div class="text-truncate small mt-1" style="max-width: 320px;">
                                                    <i class="bi bi-geo-alt text-primary me-1"></i>
                                                    <span class="text-muted">{{ $agenda->tempat ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                $status = $agenda->status ?? 'Mendatang';
                                                $badgeClass = match ($status) {
                                                'Berlangsung' => 'badge bg-success',
                                                'Selesai' => 'badge bg-secondary',
                                                default => 'badge bg-warning text-dark',
                                                };
                                                @endphp
                                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                {{ $agenda->waktu_mulai ? \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') : '-' }}
                                                -
                                                {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('agenda.show', $agenda->slug) }}"
                                                    class="btn btn-sm btn-outline-primary py-1 px-2">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">Tidak ada agenda
                                                mendatang</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <style>
                                .agenda-table {
                                    table-layout: auto;
                                    width: 100%;
                                }

                                .agenda-table th {
                                    white-space: nowrap;
                                }

                                .agenda-table td {
                                    vertical-align: middle;
                                }

                                /* Allow kegiatan column to wrap so it fits without scrolling */
                                .agenda-table td:nth-child(2) {
                                    white-space: normal;
                                }
                            </style>
                        </div>
                    </div>

                    <!-- Pengumuman Section -->
                    <div class="col-lg-4">
                        <div class="bg-white rounded-lg shadow-sm p-4 h-100 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="border-start border-3 border-warning me-2" style="height: 28px;"></div>
                                <h2 class="h5 fw-bold mb-0">Pengumuman Terkini</h2>
                                <a href="{{ route('pengumuman.index') }}"
                                    class="ms-auto small text-decoration-none text-primary">
                                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>

                            <div class="pengumuman-list flex-grow-1">
                                @php
                                $pengumuman = \App\Models\Pengumuman::query()
                                ->where('published_at', '<=', now())
                                    ->latest('published_at')
                                    ->take(3)
                                    ->get();
                                    @endphp

                                    @forelse($pengumuman as $item)
                                    <div
                                        class="pengumuman-item mb-3 p-3 rounded-lg border border-gray-100 hover-shadow transition-all duration-200">
                                        <div class="d-flex align-items-start">
                                            <div class="pengumuman-icon bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-megaphone"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="mb-1 fw-semibold text-gray-900">{{ $item->judul }}
                                                    </h6>
                                                    <small class="text-muted ms-2 text-nowrap">
                                                        <i class="bi bi-clock-history me-1"></i>
                                                        {{ $item->published_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <p class="mb-2 text-muted small">
                                                    {{ Str::limit(strip_tags($item->isi), 80) }}
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        {{ $item->published_at->translatedFormat('d M Y') }}
                                                    </span>
                                                    <a href="{{ route('pengumuman.show', $item->slug) }}"
                                                        class="text-primary small text-decoration-none">
                                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-5">
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                        <h6 class="text-muted mb-2">Belum Ada Pengumuman</h6>
                                        <p class="small text-muted mb-0">Tidak ada pengumuman yang tersedia saat ini
                                        </p>
                                    </div>
                                    @endforelse
                            </div>

                            <style>
                                .pengumuman-item {
                                    transition: all 0.3s ease;
                                    border-left: 3px solid transparent;
                                }

                                /* Image zoom effect on hover */
                                .hover-zoom {
                                    transition: transform 0.5s ease;
                                }

                                .card:hover .hover-zoom {
                                    transform: scale(1.05);
                                }

                                .card {
                                    overflow: hidden;
                                }

                                .pengumuman-item:hover {
                                    border-left-color: #ffc107;
                                    transform: translateX(4px);
                                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                                }

                                .hover-shadow {
                                    transition: box-shadow 0.3s ease;
                                }

                                .hover-shadow:hover {
                                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dokumen Section -->
        {{-- <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Dokumen Terbaru</h2>

                </div>

                <div
                    class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl shadow-md overflow-hidden border border-blue-200 w-full">
                    <div class="w-full">
                        <table class="w-full divide-y divide-blue-200 table-fixed">
                            <thead class="bg-blue-600">
                                <tr>
                                    <th scope="col"
                                        class="w-12 px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                        <i class="fas fa-hashtag"></i>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/5">
                                        <i class="far fa-file-alt mr-2"></i>Nama Dokumen
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                        <i class="fas fa-file-import mr-2"></i>Jenis
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                        <i class="far fa-calendar-alt mr-2"></i>Tanggal
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                        <i class="fas fa-cogs mr-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    use App\Models\Dokumen;

                                    $documents = Dokumen::query()
                                        ->whereNotNull('file')
                                        ->where('file', '!=', '')
                                        ->whereNotNull('published_at')
                                        ->where('published_at', '<=', now())
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get()
                                        ->map(function ($doc) {
                                            $fileExtension = pathinfo($doc->file, PATHINFO_EXTENSION);
                                            return [
                                                'name' => $doc->nama_dokumen,
                                                'type' => strtoupper($fileExtension),
                                                'date' => $doc->published_at
                                                    ? $doc->published_at->translatedFormat('d M Y')
                                                    : $doc->created_at->translatedFormat('d M Y'),
                                                'views' => $doc->views ?? 0,
                                                'downloads' => $doc->downloads ?? 0,
                                                'file' => $doc->file,
                                                'slug' => $doc->slug ?? '',
                                            ];
                                        })
                                        ->toArray();
                                @endphp

                                @foreach ($documents as $index => $doc)
                                    <tr
                                        class="hover:bg-blue-50 transition-colors duration-200 {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50' }}">
        <td class="px-3 py-3 text-center text-sm text-gray-700 font-medium w-12">
            <span
                class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-800 text-xs">
                {{ $index + 1 }}
            </span>
        </td>
        <td class="px-4 py-3 whitespace-nowrap w-2/5">
            <div class="flex items-center">
                @php
                $icon = 'fa-file-alt';
                if (str_contains(strtolower($doc['name']), 'laporan')) {
                $icon = 'fa-file-invoice';
                } elseif (str_contains(strtolower($doc['name']), 'panduan')) {
                $icon = 'fa-book';
                } elseif (str_contains(strtolower($doc['name']), 'struktur')) {
                $icon = 'fa-sitemap';
                } elseif (str_contains(strtolower($doc['name']), 'profil')) {
                $icon = 'fa-building';
                }
                @endphp
                <i class="fas {{ $icon }} text-blue-500 text-lg mr-3"></i>
                <div class="text-sm font-medium text-gray-900">{{ $doc['name'] }}
                </div>
            </div>
        </td>
        <td class="px-4 py-3 whitespace-nowrap w-1/6">
            @php
            $badgeClass = 'bg-blue-100 text-blue-800';
            if ($doc['type'] === 'PDF') {
            $badgeClass = 'bg-red-100 text-red-800';
            } elseif ($doc['type'] === 'DOCX') {
            $badgeClass = 'bg-blue-100 text-blue-800';
            } elseif ($doc['type'] === 'XLSX') {
            $badgeClass = 'bg-green-100 text-green-800';
            }
            @endphp
            <span
                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                <i class="far fa-file-{{ strtolower($doc['type']) }} mr-1"></i>
                {{ $doc['type'] }}
            </span>
        </td>
        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
            <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
            {{ $doc['date'] }}
            <div class="text-xs text-gray-500 mt-1">
                <i class="far fa-eye mr-1"></i>{{ $doc['views'] }}
                <span class="mx-1">•</span>
                <i class="fas fa-download mr-1"></i>{{ $doc['downloads'] }}
            </div>
        </td>
        <td
            class="px-4 py-3 whitespace-nowrap w-1/6 text-sm font-medium text-center space-x-2">
            <a href="{{ route('dokumen.detail', $doc['slug']) }}"
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="far fa-eye mr-1"></i>Lihat
            </a>
            <a href="{{ asset('storage/documents/' . $doc['file']) }}" download
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <i class="fas fa-download mr-1"></i>Unduh
            </a>
        </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>

    <div class="bg-blue-600 px-6 py-4 flex items-center justify-between border-t border-blue-500">
        <div class="text-sm text-white">
            <i class="fas fa-file-alt mr-2"></i>
            @php
            $totalDocuments = \App\Models\Dokumen::whereNotNull('file')
            ->where('file', '!=', '')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
                ->count();
                @endphp
                Total <span class="font-semibold">{{ $totalDocuments }} dokumen</span> tersedia untuk
                diunduh
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('dokumen.index') }}"
                class="relative inline-flex items-center px-4 py-2 border border-white text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 transition-colors duration-200">
                <i class="fas fa-list-ul mr-2"></i>Lihat Semua Dokumen
            </a>
        </div>
    </div>
</div>
</div>
</div> --}}

<!-- Section External Links -->
<section id="external-links" class="external-links-section section">
    <div class="mt-4">
        <livewire:external-links />
    </div>
</section>
</div>
</div>