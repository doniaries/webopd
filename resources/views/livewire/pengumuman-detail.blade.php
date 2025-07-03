<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        @if($pengumuman->file)
        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
            <a href="{{ asset('storage/' . $pengumuman->file) }}" 
               class="text-blue-600 hover:underline" 
               target="_blank">
                <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                <span class="block mt-2">Unduh Dokumen</span>
            </a>
        </div>
        @endif
        
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">{{ $pengumuman->judul }}</h1>
                <span class="text-sm text-gray-500">
                    {{ $pengumuman->published_at ? $pengumuman->published_at->format('d M Y') : 'Tanpa Tanggal' }}
                </span>
            </div>
            
            <div class="prose max-w-none">
                {!! $pengumuman->isi !!}
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('pengumuman.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar Pengumuman
                </a>
            </div>
        </div>
    </div>
</div>
