<div class="space-y-8">
    @use('Illuminate\Support\Facades\Storage')

    @push('title', $pageTitle)
    @push('meta')
        <meta name="description" content="{{ $pageDescription }}">
    @endpush


    <div class="space-y-8 bg-white">
        <livewire:slider />
        <!-- Berita Section -->
        <section id="berita-informasi" class="features pb-8 border-b border-gray-200 bg-white"
            style="margin: 1.5rem 0 0 0; padding: 2rem 0;">
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
                                                {{-- <span
                                                    class="badge bg-white text-dark border border-light-subtle shadow-sm">
                                                    <i class="bi bi-eye me-1" style="display: inline-block;"></i>
                                                    {{ $post->views ?? 0 }}
                                                </span> --}}
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
                        <!-- Banner Section -->
                        <div class="mb-6">
                            @livewire('banner')
                        </div>
                        <!-- End Banner Section -->
                    </div>
                </div>
            </div>
        </section>

        <!-- Agenda Section -->
        <div class="mb-4 bg-white py-8">
            <livewire:agenda-kegiatan />
        </div>

        <!-- Pengumuman Section -->
        <div class="mt-4 bg-white py-8">
            <livewire:pengumuman :limit="5" />
        </div>

        <!-- Dokumen Section -->
        <div class="py-12 bg-white">
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
                            <a href="{{ route('dokumen') }}"
                                class="relative inline-flex items-center px-4 py-2 border border-white text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 transition-colors duration-200">
                                <i class="fas fa-list-ul mr-2"></i>Lihat Semua Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section External Links -->
        <section id="external-links" class="external-links-section section">
            <div class="mt-4">
                <livewire:external-links />
            </div>
        </section>
    </div>
</div>
