<div>
    <x-page-header title="Layanan Kami" subtitle="Berbagai layanan unggulan yang kami sediakan untuk masyarakat" />
    
    <div class="py-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

    <!-- Search -->
    <div class="mb-8">
        <div class="max-w-md mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="search" 
                    class="block w-full py-3 pl-10 pr-4 text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                    placeholder="Cari layanan...">
            </div>
        </div>
    </div>
    </div>

    <!-- Layanan List -->
    @if($layanans->count() > 0)
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($layanans as $layanan)
                <div class="overflow-hidden transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">{{ $layanan->nama_layanan }}</h3>
                        @if($layanan->deskripsi)
                            <p class="mb-4 text-gray-600 line-clamp-3">
                                {{ $layanan->deskripsi }}
                            </p>
                        @endif
                        @if($layanan->persyaratan)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900">Persyaratan:</h4>
                                <p class="text-gray-600 line-clamp-2">{{ $layanan->persyaratan }}</p>
                            </div>
                        @endif
                        @if($layanan->biaya)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900">Biaya:</h4>
                                <p class="text-gray-600">{{ $layanan->biaya }}</p>
                            </div>
                        @endif
                        @if($layanan->waktu_penyelesaian)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900">Waktu Penyelesaian:</h4>
                                <p class="text-gray-600">{{ $layanan->waktu_penyelesaian }}</p>
                            </div>
                        @endif
                        @if($layanan->file)
                            <div class="mt-4">
                                <a href="{{ Storage::url($layanan->file) }}" target="_blank" class="inline-flex items-center text-sm text-primary-600 hover:text-primary-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Unduh Dokumen
                                </a>
                            </div>
                        @endif
                        <a href="{{ route('layanan.show', $layanan->slug) }}" class="inline-flex items-center font-medium text-primary-600 hover:text-primary-500">
                            Selengkapnya
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $layanans->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada layanan yang ditemukan</h3>
            <p class="mt-1 text-gray-500">Silakan coba dengan kata kunci lain</p>
        </div>
    @endif
</div>
