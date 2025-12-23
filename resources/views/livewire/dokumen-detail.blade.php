<div>
    <x-page-header :title="$dokumen->nama_dokumen" />

    <div class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                            <a href="{{ route('dokumen.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Dokumen</a>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Document Detail -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-start md:space-x-8">
                        <!-- Document Info -->
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                @php
                                $icon = 'fa-file-alt';
                                $iconColor = 'text-blue-500';
                                if (str_contains(strtolower($dokumen->nama_dokumen), 'laporan')) {
                                $icon = 'fa-file-invoice';
                                $iconColor = 'text-red-500';
                                } elseif (str_contains(strtolower($dokumen->nama_dokumen), 'panduan')) {
                                $icon = 'fa-book';
                                $iconColor = 'text-green-500';
                                }
                                @endphp
                                <i class="fas {{ $icon }} {{ $iconColor }} text-4xl mr-4"></i>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $dokumen->nama_dokumen }}</h1>
                                    <div class="flex flex-wrap items-center text-sm text-gray-500 mt-1">
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $dokumen->published_at ? $dokumen->published_at->translatedFormat('d F Y') : 'Tanpa Tanggal' }}
                                        </span>
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-eye mr-1"></i>
                                            {{ number_format($dokumen->views) }} dilihat
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-download mr-1"></i>
                                            {{ number_format($dokumen->downloads) }} unduhan
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if ($dokumen->deskripsi)
                            <div class="prose max-w-none mt-6">
                                <p class="text-gray-700">{{ $dokumen->deskripsi }}</p>
                            </div>
                            @endif

                            <!-- Document Actions -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex flex-wrap gap-4">
                                    {{-- <!-- Download Button -->
                                <a href="{{ route('dokumen.download', $dokumen->slug) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    download>
                                    <i class="fas fa-download mr-2"></i> Unduh Dokumen
                                    </a> --}}

                                    <!-- View Button (only for previewable files) -->
                                    @php
                                    $fileExtension = strtolower(pathinfo($dokumen->file, PATHINFO_EXTENSION));
                                    $canPreview = in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']);
                                    $filePath = asset('storage/' . $dokumen->file);
                                    @endphp

                                    @if ($canPreview)
                                    <a href="{{ $filePath }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        target="_blank" rel="noopener noreferrer">
                                        <i class="far fa-eye mr-2"></i> unduh dokumen
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Documents -->
            @if ($relatedDocuments->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Dokumen Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedDocuments as $doc)
                    <div
                        class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="p-4">
                            <div class="flex items-center">
                                @php
                                $icon = 'fa-file-alt text-blue-500';
                                if (str_contains(strtolower($doc->nama_dokumen), 'laporan')) {
                                $icon = 'fa-file-invoice text-red-500';
                                } elseif (str_contains(strtolower($doc->nama_dokumen), 'panduan')) {
                                $icon = 'fa-book text-green-500';
                                }
                                @endphp
                                <i class="fas {{ $icon }} text-2xl mr-3"></i>
                                <h3 class="text-sm font-medium text-gray-900 line-clamp-2">
                                    <a href="{{ route('dokumen.detail', $doc->slug) }}"
                                        class="hover:text-blue-600">
                                        {{ $doc->nama_dokumen }}
                                    </a>
                                </h3>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $doc->published_at->translatedFormat('d M Y') }}</span>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-download mr-1"></i>
                                    {{ $doc->downloads }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>