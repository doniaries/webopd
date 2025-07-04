<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dokumen</h1>
            <p class="text-gray-600">Kumpulan dokumen dan arsip resmi</p>
        </div>

        <!-- Document List -->
        @if($dokumens && $dokumens->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Dokumen</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($dokumens as $dokumen)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @php
                                                $icon = 'fa-file-alt text-blue-500';
                                                if (str_contains(strtolower($dokumen->nama_dokumen), 'laporan')) {
                                                    $icon = 'fa-file-invoice text-red-500';
                                                } elseif (str_contains(strtolower($dokumen->nama_dokumen), 'panduan')) {
                                                    $icon = 'fa-book text-green-500';
                                                }
                                                
                                                $fileExtension = pathinfo($dokumen->file, PATHINFO_EXTENSION);
                                            @endphp
                                            <i class="fas {{ $icon }} text-xl mr-3"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $dokumen->nama_dokumen }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $dokumen->published_at ? $dokumen->published_at->translatedFormat('d M Y') : 'Tanpa Tanggal' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ strtoupper($fileExtension) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $dokumen->published_at ? $dokumen->published_at->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('dokumen.detail', $dokumen->slug) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-4">
                                            <i class="far fa-eye mr-1"></i> Lihat
                                        </a>
                                        <a href="{{ route('dokumen.download', $dokumen->slug) }}" 
                                           class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-download mr-1"></i> Unduh
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $dokumens->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden p-8 text-center">
                <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada dokumen</h3>
                <p class="text-gray-500">Belum ada dokumen yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>
