<div>
    <!-- Page Title -->
    <div class="page-header relative overflow-hidden flex items-center justify-center" style="min-height: 80px; padding-top: 0.5rem;">

        <!-- Animated Bubbles -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Multiple bubbles with different sizes and speeds -->
            <div class="bubble" style="left: 10%; animation: bubble 15s infinite linear;"></div>
            <div class="bubble" style="left: 20%; animation: bubble 18s infinite linear 2s;"></div>
            <div class="bubble bubble-sm" style="left: 30%; animation: bubble 12s infinite linear 1s;"></div>
            <div class="bubble" style="left: 50%; animation: bubble 20s infinite linear 3s;"></div>
            <div class="bubble bubble-sm" style="left: 70%; animation: bubble 14s infinite linear 4s;"></div>
            <div class="bubble" style="left: 85%; animation: bubble 16s infinite linear 1.5s;"></div>


        </div>

        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10">
            <!-- Breadcrumb -->
            <nav class="text-sm text-white mb-4">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-blue transition-colors duration-200">Beranda</a>
                    </li>
                    <li class="text-white">/</li>
                    <li class="text-white font-medium">
                        {{ ucwords(str_replace('-', ' ', request()->segment(count(request()->segments())))) }}</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="text-center -mt-2">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                    @php
                        $segments = request()->segments();
                        $title = end($segments) ?: 'Beranda';
                        $title = str_replace('-', ' ', $title);
                        $title = ucwords($title);
                        
                        // Handle empty segments (homepage)
                        if (empty($title)) {
                            $title = 'Beranda';
                        }
                        
                        echo $title;
                    @endphp
                </h1>
            </div>
        </div>

        <!-- Bottom wave decoration -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden">
            <svg class="relative block w-full h-8" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C150,120 350,0 600,60 C850,120 1050,0 1200,60 L1200,120 L0,120 Z"
                    fill="rgba(255,255,255,0.1)"></path>
            </svg>
        </div>
    </div><!-- End Page Title -->

    <style>
        /* Animations */
        @keyframes bubble {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-100vh) translateX(20px);
                opacity: 0;
            }
        }

        /* Bubbles */
        .bubble {
            position: absolute;
            bottom: -20px;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .bubble-sm {
            width: 6px;
            height: 6px;
            opacity: 0.4;
        }

        /* Page Header */
        .page-header {
            min-height: 120px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(to bottom, #1e40af 0%, #3b82f6 100%);
        }

        /* Wave Animation */
        @keyframes wave {
            0% {
                transform: translateX(0) translateZ(0);
            }

            100% {
                transform: translateX(-50%) translateZ(0);
            }
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-header {
                min-height: 110px;
            }

            h1 {
                font-size: 1.8rem !important;
            }
        }
    </style>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-body p-4">
                        @if ($informasi->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($informasi as $item)
                                    @php
                                        $cardStyles = [
                                            [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'icon_bg' => 'bg-blue-200',
                                                'icon_text' => 'text-blue-600',
                                                'button_bg' => 'bg-blue-600',
                                                'button_hover_bg' => 'bg-blue-700',
                                                'button_ring' => 'focus:ring-blue-300',
                                            ],
                                            [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'icon_bg' => 'bg-green-200',
                                                'icon_text' => 'text-green-600',
                                                'button_bg' => 'bg-green-600',
                                                'button_hover_bg' => 'bg-green-700',
                                                'button_ring' => 'focus:ring-green-300',
                                            ],
                                            [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'icon_bg' => 'bg-yellow-200',
                                                'icon_text' => 'text-yellow-600',
                                                'button_bg' => 'bg-yellow-600',
                                                'button_hover_bg' => 'bg-yellow-700',
                                                'button_ring' => 'focus:ring-yellow-300',
                                            ],
                                            [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-800',
                                                'icon_bg' => 'bg-red-200',
                                                'icon_text' => 'text-red-600',
                                                'button_bg' => 'bg-red-600',
                                                'button_hover_bg' => 'bg-red-700',
                                                'button_ring' => 'focus:ring-red-300',
                                            ],
                                            [
                                                'bg' => 'bg-purple-100',
                                                'text' => 'text-purple-800',
                                                'icon_bg' => 'bg-purple-200',
                                                'icon_text' => 'text-purple-600',
                                                'button_bg' => 'bg-purple-600',
                                                'button_hover_bg' => 'bg-purple-700',
                                                'button_ring' => 'focus:ring-purple-300',
                                            ],
                                            [
                                                'bg' => 'bg-pink-100',
                                                'text' => 'text-pink-800',
                                                'icon_bg' => 'bg-pink-200',
                                                'icon_text' => 'text-pink-600',
                                                'button_bg' => 'bg-pink-600',
                                                'button_hover_bg' => 'bg-pink-700',
                                                'button_ring' => 'focus:ring-pink-300',
                                            ],
                                        ];
                                        $index = $loop->index % count($cardStyles);
                                        $style = $cardStyles[$index];
                                    @endphp
                                    <div
                                        class="card-article bg-white rounded-lg overflow-hidden h-full flex flex-col border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                        <div class="p-5 flex-1 flex flex-col">
                                            <h3 class="text-base font-semibold text-gray-800 mb-2">
                                                {{ $item->judul }}
                                            </h3>
                                            <div class="text-xs text-gray-500 mb-3">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $item->published_at->translatedFormat('d F Y') }}
                                                <span class="mx-2">•</span>
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $item->published_at->format('H:i') }} WIB
                                            </div>
                                            <div class="prose prose-sm max-w-none text-gray-600 mb-4">
                                                {!! $item->isi !!}
                                            </div>

                                            {{-- Lampiran File --}}
                                            @php
                                                $files = is_array($item->file) ? $item->file : [$item->file];
                                                $hasFiles = !empty(array_filter($files));
                                            @endphp
                                            @if ($hasFiles)
                                                <div class="mt-4 pt-3 border-t border-gray-100">
                                                    <div class="space-y-3">
                                                        <p class="text-sm font-medium text-gray-800 mb-2">Lampiran
                                                            Dokumen:</p>
                                                        @foreach ($files as $file)
                                                            @if ($file)
                                                                @php
                                                                    $filePath = str_starts_with($file, 'public/')
                                                                        ? $file
                                                                        : 'public/' . $file;
                                                                    $fileExists = Storage::exists($filePath);
                                                                    $fileSize = $fileExists
                                                                        ? number_format(
                                                                                Storage::size($filePath) / 1024,
                                                                                1,
                                                                            ) . ' KB'
                                                                        : '';
                                                                    $fileName = basename($file);
                                                                    $fileUrl = $fileExists ? Storage::url($file) : '#';
                                                                    $isPdf =
                                                                        strtolower(
                                                                            pathinfo($file, PATHINFO_EXTENSION),
                                                                        ) === 'pdf';
                                                                @endphp
                                                                <div
                                                                    class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
                                                                    <div class="flex items-start">
                                                                        <div
                                                                            class="flex-shrink-0 bg-red-50 p-2 rounded-md">
                                                                            <i
                                                                                class="bi bi-file-earmark-pdf-fill text-red-500 text-2xl"></i>
                                                                        </div>
                                                                        <div class="ml-3 flex-1 min-w-0">
                                                                            <p
                                                                                class="text-sm font-medium text-gray-900 truncate">
                                                                                {{ $fileName }}
                                                                            </p>
                                                                            <div class="flex items-center mt-1">
                                                                                <span
                                                                                    class="text-xs text-gray-500">{{ $fileSize }}</span>
                                                                                <span
                                                                                    class="mx-2 text-gray-300">•</span>
                                                                                <span
                                                                                    class="text-xs text-gray-500">PDF</span>
                                                                            </div>
                                                                        </div>
                                                                        @if ($fileExists)
                                                                            <div class="ml-4 flex-shrink-0">
                                                                                <div class="group relative">
                                                                                    <a href="{{ $fileUrl }}"
                                                                                        target="_blank"
                                                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md"
                                                                                        download>
                                                                                        <i
                                                                                            class="bi bi-download mr-1.5"></i>
                                                                                        Unduh
                                                                                    </a>
                                                                                    <div
                                                                                        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                                                                        Unduh Dokumen
                                                                                        <div
                                                                                            class="absolute bottom-0 left-1/2 w-2 h-2 -mb-1 -translate-x-1/2 transform rotate-45 bg-gray-800">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 text-right">
                                            <span class="text-xs text-gray-500">
                                                Dipublikasikan oleh: {{ $item->user->name ?? 'Admin' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-6 text-center">
                                @if ($informasi->hasMorePages())
                                    <button wire:click="loadMore"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-colors duration-300">
                                        Muat Lebih Banyak
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-blue-700">Tidak ada informasi yang tersedia saat ini.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card-article {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 0, 0, 0.1);
            }

            .card-article:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .article-title {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                min-height: 3em;
            }

            .article-excerpt {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                min-height: 4.5em;
            }
        </style>
    @endpush
</div>

@push('scripts')
    <script>
        // Inisialisasi tabel shadow setelah Livewire selesai memuat
        document.addEventListener('livewire:load', function() {
            document.querySelectorAll('table').forEach(function(tbl) {
                tbl.classList.add('shadow-table');
            });
        });
    </script>
@endpush
</div>
