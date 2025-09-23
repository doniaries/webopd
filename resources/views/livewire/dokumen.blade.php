<div>
    <x-page-header title="Dokumen Publik" subtitle="Kumpulan dokumen dan arsip resmi" />
    
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Document List -->
            @if ($dokumens && $dokumens->count() > 0)
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl shadow-lg overflow-hidden border border-blue-200">
                    <div class="w-full">
                        <table class="w-full divide-y divide-blue-200 table-fixed">
                            <thead class="bg-blue-600">
                                <tr>
                                    <th scope="col" class="w-12 px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                        <i class="fas fa-hashtag"></i>
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/5">
                                        <i class="far fa-file-alt mr-2"></i>Nama Dokumen
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                        <i class="fas fa-file-import mr-2"></i>Jenis
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                        <i class="far fa-calendar-alt mr-2"></i>Tanggal
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                        <i class="fas fa-cogs mr-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($dokumens as $index => $dokumen)
                                    @php
                                        $fileExtension = pathinfo($dokumen->file, PATHINFO_EXTENSION);
                                    @endphp
                                    <tr class="hover:bg-blue-50 transition-colors duration-200 {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50' }}">
                                        <td class="px-3 py-3 text-center text-sm text-gray-700 font-medium w-12">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-800 text-xs">
                                                {{ $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap w-2/5">
                                            <div class="flex items-center">
                                                @php
                                                    $icon = 'fa-file-alt';
                                                    if (str_contains(strtolower($dokumen->nama_dokumen), 'laporan')) {
                                                        $icon = 'fa-file-invoice';
                                                    } elseif (str_contains(strtolower($dokumen->nama_dokumen), 'panduan')) {
                                                        $icon = 'fa-book';
                                                    } elseif (str_contains(strtolower($dokumen->nama_dokumen), 'struktur')) {
                                                        $icon = 'fa-sitemap';
                                                    } elseif (str_contains(strtolower($dokumen->nama_dokumen), 'profil')) {
                                                        $icon = 'fa-building';
                                                    }
                                                @endphp
                                                <i class="fas {{ $icon }} text-blue-500 text-lg mr-3"></i>
                                                <div class="text-sm font-medium text-gray-900">{{ $dokumen->nama_dokumen }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap w-1/6">
                                            @php
                                                $badgeClass = 'bg-blue-100 text-blue-800';
                                                if (strtoupper($fileExtension) === 'PDF') {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif (strtoupper($fileExtension) === 'DOCX') {
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                } elseif (strtoupper($fileExtension) === 'XLSX') {
                                                    $badgeClass = 'bg-green-100 text-green-800';
                                                }
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                <i class="far fa-file-{{ strtolower($fileExtension) }} mr-1"></i>
                                                {{ strtoupper($fileExtension) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                                            {{ $dokumen->published_at ? $dokumen->published_at->translatedFormat('d M Y') : 'Tanpa Tanggal' }}
                                            <div class="text-xs text-gray-500 mt-1">
                                                <i class="far fa-eye mr-1"></i>{{ $dokumen->views ?? 0 }}
                                                <span class="mx-1">•</span>
                                                <i class="fas fa-download mr-1"></i>{{ $dokumen->downloads ?? 0 }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap w-1/6 text-sm font-medium text-center space-x-2">
                                            <a href="{{ route('dokumen.detail', $dokumen->slug) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <i class="far fa-eye mr-1"></i>Lihat
                                            </a>
                                            <a href="{{ route('dokumen.download', $dokumen->slug) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                <i class="fas fa-download mr-1"></i>Unduh
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($dokumens->hasPages())
                        <div class="bg-blue-600 px-6 py-4 flex items-center justify-between border-t border-blue-500">
                            <div class="text-sm text-white">
                                <i class="fas fa-file-alt mr-2"></i>
                                Menampilkan {{ $dokumens->firstItem() }} - {{ $dokumens->lastItem() }} dari {{ $dokumens->total() }} dokumen
                            </div>
                            <div class="flex-1 flex justify-end">
                                {{ $dokumens->links() }}
                            </div>
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
</div>
