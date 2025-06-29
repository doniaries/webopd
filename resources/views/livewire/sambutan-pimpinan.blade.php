<div>
    <x-page-header title="Sambutan Pimpinan" />

    @if ($sambutan)
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Content Area -->
                    <div class="p-8 md:pr-12 md:border-r border-gray-200 md:w-2/3">
                        <h2 class="text-2xl font-bold mb-6 text-blue-800">{{ $sambutan->jabatan ?? 'Sambutan Pimpinan' }}
                        </h2>
                        <div class="prose text-gray-700 leading-relaxed">
                            {!! strip_tags($sambutan->isi_sambutan) !!}
                        </div>
                    </div>

                    <!-- Photo Area -->
                    <div class="md:w-1/3 p-6 flex items-center justify-center">
                        @if ($sambutan->foto)
                            <div class="w-full max-w-xs">
                                <div class="relative overflow-hidden rounded-lg shadow-md">
                                    <img src="{{ asset('storage/' . $sambutan->foto) }}"
                                        alt="{{ $sambutan->nama ?? 'Foto Pimpinan' }}"
                                        class="w-full h-auto object-cover">
                                    <div class="bg-blue-800 text-white p-3 text-center">
                                        <div class="font-semibold">{{ $sambutan->nama ?? '' }}</div>
                                        <div class="text-sm opacity-90">
                                            {{ $sambutan->jabatan ?? 'Kepala Dinas Komunikasi dan Informatika' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Data sambutan pimpinan belum tersedia. Silakan hubungi administrator untuk mengisi data ini.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
