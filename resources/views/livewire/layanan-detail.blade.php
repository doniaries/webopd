<div>
    <x-page-header :title="$layanan->nama_layanan" />
    
    <div class="py-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Back button -->
        <div class="mb-6">
            <a href="{{ route('layanan.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Layanan
            </a>
        </div>

        <!-- Service Detail -->
        <article class="max-w-4xl mx-auto">
            <div class="prose max-w-none">
            
            @if($layanan->gambar)
                <div class="mt-6 overflow-hidden rounded-lg">
                    <img src="{{ Storage::url($layanan->gambar) }}" alt="{{ $layanan->nama_layanan }}" class="object-cover w-full h-64 md:h-96">
                </div>
            @endif
        </header>

        <div class="prose max-w-none">
            {!! $layanan->konten !!}
        </div>

        @if($layanan->persyaratan)
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-900">Persyaratan</h3>
                <div class="mt-4 prose max-w-none">
                    {!! $layanan->persyaratan !!}
                </div>
            </div>
        @endif

        @if($layanan->biaya)
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-900">Biaya</h3>
                <div class="mt-4 prose max-w-none">
                    {!! $layanan->biaya !!}
                </div>
            </div>
        @endif

        @if($layanan->waktu_penyelesaian)
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-900">Waktu Penyelesaian</h3>
                <div class="mt-4 prose max-w-none">
                    {!! $layanan->waktu_penyelesaian !!}
                </div>
            </div>
        @endif
    </article>

    <!-- Related Services -->
    @if($relatedServices->isNotEmpty())
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900">Layanan Lainnya</h2>
            <div class="grid gap-6 mt-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedServices as $related)
                    <div class="overflow-hidden transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                        @if($related->gambar)
                            <img class="object-cover w-full h-48" src="{{ Storage::url($related->gambar) }}" alt="{{ $related->nama_layanan }}">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $related->nama_layanan }}</h3>
                            <p class="mt-2 text-gray-600 line-clamp-3">
                                {{ $related->deskripsi }}
                            </p>
                            <a href="{{ route('layanan.show', $related->slug) }}" class="inline-flex items-center mt-4 font-medium text-primary-600 hover:text-primary-500">
                                Selengkapnya
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
