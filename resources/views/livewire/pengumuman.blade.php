<div>
    @push('styles')
    <style>
        @keyframes flash {
            0% { background-color: rgba(254, 202, 202, 0.8); }
            100% { background-color: transparent; }
        }
        
        .flash-effect {
            animation: flash 1.5s ease-out;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
    @endpush

    @if($view === 'show')
        <div class="py-8 bg-gray-50 fade-in">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
                    <div class="mb-4">
                        <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pengumuman
                        </a>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $pengumuman->judul }}</h1>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-6">
                        <i class="far fa-calendar-alt mr-2"></i>
                        <span>{{ $pengumuman->published_at->translatedFormat('d F Y') }}</span>
                        <span class="mx-2">•</span>
                        <i class="far fa-eye mr-2"></i>
                        <span>{{ $pengumuman->views }} kali dilihat</span>
                    </div>
                    
                    <div class="prose max-w-none mb-6">
                        {!! $pengumuman->isi !!}
                    </div>
                    
                    @if($pengumuman->file)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-900 mb-2">Lampiran:</h3>
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                <a href="{{ Storage::url($pengumuman->file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 mr-4">
                                    Lihat Dokumen
                                </a>
                                <a href="{{ Storage::url($pengumuman->file) }}" download class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition duration-300">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="py-8 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <span class="w-2 h-8 bg-red-600 mr-3"></span>
                        Daftar Pengumuman
                    </h1>
                    <p class="mt-2 text-gray-600">Informasi terbaru dan pengumuman penting</p>
                </div>

                @if (isset($pengumuman) && $pengumuman->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="pengumuman-list">
                        @foreach ($pengumuman as $item)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" wire:key="{{ $item->id }}">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-bullhorn text-red-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                            {{ $item->judul }}
                                        </h3>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="flex items-center text-sm text-gray-500 mb-3">
                                            <i class="far fa-calendar-alt mr-2"></i>
                                            <span>{{ $item->published_at->translatedFormat('d F Y') }}</span>
                                            @if($item->views > 0)
                                                <span class="mx-2">•</span>
                                                <i class="far fa-eye mr-2"></i>
                                                <span>{{ $item->views }} kali dilihat</span>
                                            @endif
                                        </div>
                                        
                                        <div class="prose prose-sm max-w-none mb-4 line-clamp-3 text-gray-600">
                                            {!! $item->isi !!}
                                        </div>
                                    </div>
                                    
                                    @if($item->file)
                                        <div class="mb-4 p-3 bg-gray-50 rounded-lg text-sm">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                                <span class="text-gray-700 truncate">Lampiran tersedia</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-4 flex justify-end">
                                        <a href="{{ route('pengumuman.show', $item->slug) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-300">
                                            <span>Baca Selengkapnya</span>
                                            <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8 bg-white rounded-lg shadow-sm p-4">
                        {{ $pengumuman->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden text-center py-12">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Belum ada pengumuman yang tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener('livewire:navigating', () => {
                document.querySelectorAll('#pengumuman-list > div').forEach(item => {
                    item.classList.add('flash-effect');
                });
            });
        </script>
    @endif
</div>
