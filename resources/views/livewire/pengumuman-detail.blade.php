<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <div class="flex items-center">
                    <a href="{{ route('pengumuman.index') }}" 
                       class="text-white hover:text-blue-100 mr-4">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <h1 class="text-2xl font-bold text-white">Detail Pengumuman</h1>
                </div>
            </div>

            <!-- Document Preview (if file exists) -->
            @if($pengumuman->file)
            <div class="bg-gray-50 p-6 border-b border-gray-200">
                <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-lg bg-white">
                    <i class="fas fa-file-pdf text-5xl text-red-500 mb-3"></i>
                    <p class="text-gray-700 mb-4">Dokumen terlampir</p>
                    <a href="{{ asset('storage/' . $pengumuman->file) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <i class="fas fa-download mr-2"></i>
                        Unduh Dokumen
                    </a>
                </div>
            </div>
            @endif
            
            <!-- Content -->
            <div class="p-6 sm:p-8">
                <!-- Title and Date -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2 sm:mb-0">{{ $pengumuman->judul }}</h2>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>
                                {{ $pengumuman->published_at ? $pengumuman->published_at->translatedFormat('l, d F Y') : 'Tanpa Tanggal' }}
                                @if($pengumuman->published_at)
                                    <span class="text-gray-400 ml-2">({{ $pengumuman->published_at->diffForHumans() }})</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    @if($pengumuman->kategori)
                    <div class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full mb-4">
                        {{ $pengumuman->kategori }}
                    </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="prose max-w-none text-gray-700">
                    {!! $pengumuman->isi !!}
                </div>
                
                <!-- Attachments (if any) -->
                @if($pengumuman->lampiran)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-paperclip mr-2"></i>Lampiran
                    </h3>
                    <div class="space-y-2">
                        @foreach(json_decode($pengumuman->lampiran) as $file)
                        <a href="{{ asset('storage/' . $file->path) }}" 
                           target="_blank"
                           class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-file-alt text-blue-500 mr-3 text-xl"></i>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $file->name }}</p>
                                <p class="text-xs text-gray-500">{{ $file->size ?? 'Ukuran tidak tersedia' }}</p>
                            </div>
                            <i class="fas fa-download text-gray-400 ml-2"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Back Button -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('pengumuman.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar Pengumuman
                    </a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between gap-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="far fa-user mr-2"></i>
                        <span class="font-medium">{{ $pengumuman->penulis ?? 'Admin' }}</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center" title="Jumlah dilihat">
                            <i class="far fa-eye mr-2"></i>
                            <span>{{ $pengumuman->view_count_formatted }}x dilihat</span>
                        </div>
                        <div class="hidden sm:block">•</div>
                        <div class="flex items-center" title="Terakhir diperbarui">
                            <i class="far fa-clock mr-2"></i>
                            <span>Diperbarui {{ $pengumuman->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
