<div>
    <x-page-header title="Informasi Terbaru" :breadcrumbs="['Informasi' => route('informasi.index')]">
    </x-page-header>
    <style>
        /* Efek bayangan untuk tabel */
        table.shadow-table {
            box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.10), 0 1.5px 8px 0 rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            overflow: hidden;
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
                                        class="card-article bg-white rounded-lg overflow-hidden h-full flex flex-col border border-gray-200">
                                        <div class="p-5 flex-1 flex flex-col">
                                            <div class="mb-3">
                                                <div class="text-xs font-medium text-blue-600 mb-2">
                                                    {{ $item->published_at->translatedFormat('d M Y') }} •
                                                    {{ $item->published_at->format('H:i') }} WIB
                                                </div>
                                                <h3 class="text-base font-semibold text-gray-800 mb-2 article-title" style="line-height: 1.3;">
                                                    <a href="{{ route('informasi.show', $item->slug) }}"
                                                        class="hover:text-blue-600 transition-colors duration-300">
                                                        {{ $item->judul }}
                                                    </a>
                                                </h3>
                                                <p class="text-gray-600 text-sm mb-4 article-excerpt">
                                                    {{ Str::limit(strip_tags($item->isi), 150) }}
                                                </p>
                                            </div>
                                            <div class="mt-auto">
                                                <a href="{{ route('informasi.show', $item->slug) }}"
                                                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300">
                                                    Selengkapnya
                                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
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
