<div class="-mt-6 space-y-4">
    @if ($informasi && $informasi->count() > 0)
        @foreach ($informasi as $item)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <a href="{{ route('informasi.detail', $item->slug) }}" class="block">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="bg-blue-50 p-3 rounded-lg mr-4">
                                <i class="fas fa-bullhorn text-blue-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2 hover:text-blue-600">
                                    {{ $item->judul }}
                                </h4>
                                <div class="flex flex-wrap items-center text-xs text-gray-500 space-x-3">
                                    <span class="flex items-center">
                                        <i class="far fa-calendar-alt mr-1 text-blue-500"></i>
                                        {{ $item->created_at->translatedFormat('d M Y') }}
                                    </span>
                                    @if (isset($item->kategori))
                                        <span class="flex items-center">
                                            <i class="fas fa-tag mr-1 text-blue-500"></i>
                                            {{ $item->kategori->nama }}
                                        </span>
                                    @endif
                                    @if (isset($item->penulis))
                                        <span class="flex items-center">
                                            <i class="fas fa-user-edit mr-1 text-blue-500"></i>
                                            {{ $item->penulis->name }}
                                        </span>
                                    @endif
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-white text-dark border border-light-subtle shadow-sm">
                                        <i class="bi bi-eye me-1" style="display: inline-block;"></i>
                                        {{ $item->views ?? 0 }}
                                    </span>

                                </div>
                                @if (isset($item->dokumen) && $item->dokumen->count() > 0)
                                    <div class="mt-2">
                                        <span
                                            class="inline-flex items-center text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded">
                                            <i class="far fa-file-pdf mr-1 text-red-500"></i>
                                            {{ $item->dokumen->count() }} Lampiran
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        <div class="mt-4 text-center">
            <a href="{{ route('informasi.index') }}"
                class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                Lihat Semua Informasi
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    @else
        <div class="text-center py-6 bg-gray-50 rounded-lg">
            <div class="text-gray-400 mb-2">
                <i class="fas fa-info-circle text-4xl"></i>
            </div>
            <p class="text-sm text-gray-500">
                @if (!$informasi)
                    Gagal memuat data informasi
                @else
                    Belum ada informasi terbaru
                @endif
            </p>
        </div>
    @endif
</div>
