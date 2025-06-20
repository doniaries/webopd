<div>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 rounded-t-lg shadow-lg">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xl font-bold text-white">
                                <span class="flex items-center gap-2">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    Informasi Terbaru
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($informasi->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($informasi as $item)
                                    @php
                                        $cardStyles = [
                                            ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon_bg' => 'bg-blue-200', 'icon_text' => 'text-blue-600', 'button_bg' => 'bg-blue-600', 'button_hover_bg' => 'bg-blue-700', 'button_ring' => 'focus:ring-blue-300'],
                                            ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon_bg' => 'bg-green-200', 'icon_text' => 'text-green-600', 'button_bg' => 'bg-green-600', 'button_hover_bg' => 'bg-green-700', 'button_ring' => 'focus:ring-green-300'],
                                            ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon_bg' => 'bg-yellow-200', 'icon_text' => 'text-yellow-600', 'button_bg' => 'bg-yellow-600', 'button_hover_bg' => 'bg-yellow-700', 'button_ring' => 'focus:ring-yellow-300'],
                                            ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon_bg' => 'bg-red-200', 'icon_text' => 'text-red-600', 'button_bg' => 'bg-red-600', 'button_hover_bg' => 'bg-red-700', 'button_ring' => 'focus:ring-red-300'],
                                            ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon_bg' => 'bg-purple-200', 'icon_text' => 'text-purple-600', 'button_bg' => 'bg-purple-600', 'button_hover_bg' => 'bg-purple-700', 'button_ring' => 'focus:ring-purple-300'],
                                            ['bg' => 'bg-pink-100', 'text' => 'text-pink-800', 'icon_bg' => 'bg-pink-200', 'icon_text' => 'text-pink-600', 'button_bg' => 'bg-pink-600', 'button_hover_bg' => 'bg-pink-700', 'button_ring' => 'focus:ring-pink-300']
                                        ];
                                        $index = $loop->index % count($cardStyles);
                                        $style = $cardStyles[$index];
                                    @endphp
                                    <div
                                        class="{{ $style['bg'] }} rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        <div class="p-5">
                                            <div class="flex items-center mb-4">
                                                <div class="bg-blue-50 rounded-full p-2">
                                                    <svg class="w-5 h-5 text-blue-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('informasi.show', $item->slug) }}"
                                                        class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition-colors duration-300">
                                                        {{ $item->judul }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-gray-600 text-sm leading-relaxed">
                                                    {{ Str::limit(strip_tags($item->isi), 120) }}
                                                </p>
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
