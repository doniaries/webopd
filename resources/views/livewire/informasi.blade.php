<div>
    <style>
        /* Efek bayangan untuk tabel */
        table.shadow-table {
            box-shadow: 0 4px 16px 0 rgba(0,0,0,0.10), 0 1.5px 8px 0 rgba(0,0,0,0.06);
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 rounded-t-lg shadow-lg">
                        <h4 class="text-xl font-bold text-center text-white">
                            Informasi Terbaru
                        </h4>
                    </div>
                    <div class="card-body">
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
                                        class="{{ $style['bg'] }} rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] hover:z-10">
                                        <div class="p-5">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center">
                                                <a href="{{ route('informasi.show', $item->slug) }}" class="hover:text-blue-600 transition-colors duration-300">
                                                    {{ $item->judul }}
                                                </a>
                                            </h3>
                                            <div class="mb-4">
                                                <p class="text-gray-600 text-sm leading-relaxed mb-3">
                                                    {{ Str::limit(strip_tags($item->isi), 120) }}
                                                </p>
                                                <div class="flex items-center text-xs text-gray-500 space-x-4">
                                                    <span class="flex items-center">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        {{ $item->published_at->translatedFormat('l, j F Y') }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $item->published_at->format('H:i') }} WIB
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex justify-end">
                                                <a href="{{ route('informasi.show', $item->slug) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors duration-300">
                                                    Baca Selengkapnya
                                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
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
