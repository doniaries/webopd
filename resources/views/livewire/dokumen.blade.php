<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Dokumen</h1>
            <p class="text-gray-600 text-sm md:text-base">Kumpulan dokumen dan arsip resmi</p>
        </div>

        <!-- Document List -->
        @if ($dokumens && $dokumens->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($dokumens as $dokumen)
                        @php
                            $icon = 'fa-file-alt text-blue-500';
                            if (str_contains(strtolower($dokumen->nama_dokumen), 'laporan')) {
                                $icon = 'fa-file-invoice text-red-500';
                            } elseif (str_contains(strtolower($dokumen->nama_dokumen), 'panduan')) {
                                $icon = 'fa-book text-green-500';
                            }
                            $fileExtension = pathinfo($dokumen->file, PATHINFO_EXTENSION);
                        @endphp
                        
                        <div class="group border border-gray-100 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-start justify-between h-full">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start">
                                        <i class="fas {{ $icon }} text-2xl mt-0.5 mr-3 group-hover:scale-110 transition-transform"></i>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                                {{ $dokumen->nama_dokumen }}
                                            </h3>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <span class="inline-flex items-center">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ $dokumen->published_at ? $dokumen->published_at->translatedFormat('d M Y') : 'Tanpa Tanggal' }}
                                                </span>
                                                <span class="mx-2 text-gray-300">•</span>
                                                <span class="inline-flex items-center">
                                                    <i class="far fa-file mr-1"></i>
                                                    {{ strtoupper($fileExtension) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-3 flex-shrink-0 flex space-x-1">
                                    <a href="{{ route('dokumen.detail', $dokumen->slug) }}"
                                        class="inline-flex items-center p-1.5 rounded-full text-blue-600 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors"
                                        title="Lihat Detail">
                                        <i class="far fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('dokumen.download', $dokumen->slug) }}"
                                        class="inline-flex items-center p-1.5 rounded-full text-green-600 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-colors"
                                        download
                                        title="Unduh Dokumen">
                                        <i class="fas fa-download text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($dokumens->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $dokumen->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada dokumen</h3>
                <p class="text-gray-500">Belum ada dokumen yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>
