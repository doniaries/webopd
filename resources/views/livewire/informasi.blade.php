<div>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 rounded-t-lg shadow-lg">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xl font-bold text-white">
                                <span class="flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Informasi Terbaru
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($informasi->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($informasi as $item)
                                    <div
                                        class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                                        <div class="p-5">
                                            <div class="flex items-center mb-4">
                                                <div class="bg-blue-100 rounded-full p-3">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('informasi.show', $item->slug) }}"
                                                        class="text-xl font-semibold text-gray-800 hover:text-blue-600 transition-colors duration-300">
                                                        {{ $item->judul }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-gray-600">
                                                    {{ Str::limit(strip_tags($item->isi), 150) }}
                                                </p>
                                            </div>
                                            <div class="flex justify-end">
                                                <a href="{{ route('informasi.show', $item->slug) }}"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg hover:from-blue-600 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
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
                            <div class="mt-6">
                                {{ $informasi->links() }}
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
