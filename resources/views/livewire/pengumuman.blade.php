<div>
    <x-page-header title="Pengumuman" subtitle="Informasi dan pengumuman terbaru" />
    
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div
            class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl shadow-md overflow-hidden border border-blue-200">
            @if ($pengumuman->count() > 0)
                <div class="w-full overflow-x-auto">
                    <table class="w-full table-auto divide-y divide-blue-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th scope="col"
                                    class="w-12 px-2 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-hashtag"></i>
                                </th>
                                <th scope="col"
                                    class="min-w-[250px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-bullhorn mr-2"></i>Judul Pengumuman
                                </th>
                                <th scope="col"
                                    class="min-w-[250px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-align-left mr-2"></i>Ringkasan
                                </th>
                                <th scope="col"
                                    class="min-w-[180px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="far fa-calendar mr-2"></i>Tanggal
                                </th>
                                <th scope="col"
                                    class="w-24 px-2 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="far fa-eye mr-1"></i>Dilihat
                                </th>
                                <th scope="col"
                                    class="w-24 px-2 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-1"></i>Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pengumuman as $index => $item)
                                @php
                                    $rowClass = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                                @endphp
                                <tr class="{{ $rowClass }} group hover:bg-blue-50 transition-colors">
                                    <td class="px-2 py-3 text-center text-sm text-gray-700 font-medium">
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-800 text-xs group-hover:bg-blue-200 transition-colors">
                                            {{ ($pengumuman->currentPage() - 1) * $pengumuman->perPage() + $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-sm font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <i class="fas fa-bullhorn text-blue-500 mr-2 flex-shrink-0"></i>
                                            <a href="{{ route('pengumuman.show', $item->slug) }}"
                                                class="truncate max-w-[200px] hover:text-blue-600 transition-colors flex-1 block py-1">
                                                {{ $item->judul }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-600">
                                        <div class="line-clamp-2">
                                            @php
                                                $cleanContent = strip_tags($item->isi);
                                                $excerpt = Str::limit($cleanContent, 120);
                                            @endphp
                                            {{ $excerpt }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="far fa-calendar text-blue-500 mr-2 flex-shrink-0"></i>
                                            <div>
                                                <div class="font-medium">
                                                    {{ $item->created_at->translatedFormat('l, d F Y') }}</div>
                                                <div class="text-xs text-gray-500">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $item->created_at->translatedFormat('H:i') }} WIB •
                                                    {{ $item->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center">
                                            <i class="far fa-eye text-gray-400 mr-1 text-sm"></i>
                                            <span
                                                class="text-sm font-medium text-gray-700">{{ $item->view_count_formatted }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-3">
                                        <div class="flex items-center justify-center space-x-1">
                                            <!-- Detail Button -->
                                            <a href="{{ route('pengumuman.show', $item->slug) }}"
                                                class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                                                title="Lihat Detail">
                                                <i class="mr-1 fas fa-eye"></i> Detail
                                            </a>

                                            {{-- <!-- PDF Button (Conditional) -->
                                            @if ($item->file)
                                            <a href="{{ asset('storage/' . $item->file) }}" 
                                               target="_blank"
                                               class="inline-flex items-center justify-center w-8 h-8 ml-1 text-red-500 bg-white border border-gray-200 rounded-full shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                               title="Unduh Dokumen">
                                                <i class="text-sm fas fa-file-pdf"></i>
                                            </a>
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr class="{{ $rowClass }} hover:bg-blue-50 transition-colors">
                                    <td colspan="5"
                                        class="px-4 py-2 text-sm text-gray-600 border-t border-gray-100 bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-xs text-gray-500">
                                                {{-- <span class="flex items-center mr-4">
                                                    <i class="far fa-user mr-1"></i>
                                                    <span class="font-medium">{{ $item->penulis ?? 'Admin' }}</span>
                                                </span> --}}
                                                {{-- <span class="flex items-center mr-4">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    <span>{{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                                        WIB</span>
                                                </span> --}}
                                                <div class="flex items-center space-x-2">
                                                    @if ($item->kategori)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $item->kategori }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($showPagination)
                    <!-- Pagination -->
                    <div class="bg-white px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                            <div class="text-sm text-gray-600">
                                @if ($showPagination)
                                    Menampilkan <span class="font-medium">{{ $pengumuman->firstItem() }}</span> sampai
                                    <span class="font-medium">{{ $pengumuman->lastItem() }}</span> dari
                                    <span class="font-medium">{{ $pengumuman->total() }}</span> hasil
                                @else
                                    Menampilkan <span class="font-medium">{{ $pengumuman->count() }}</span> pengumuman
                                    terbaru
                                @endif
                            </div>

                            <nav aria-label="Page navigation">
                                <ul class="inline-flex -space-x-px text-sm">
                                    <!-- Previous Button -->
                                    @if ($pengumuman->onFirstPage())
                                        <li>
                                            <span
                                                class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $pengumuman->previousPageUrl() }}"
                                                class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-900">
                                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Page Numbers -->
                                    @if ($showPagination)
                                        @php
                                            $currentPage = $pengumuman->currentPage();
                                            $lastPage = $pengumuman->lastPage();
                                            $start = max(1, $currentPage - 2);
                                            $end = min($lastPage, $currentPage + 2);
                                        @endphp

                                        @if ($start > 1)
                                            <li>
                                                <a href="{{ $pengumuman->url(1) }}"
                                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-900">1</a>
                                            </li>
                                            @if ($start > 2)
                                                <li>
                                                    <span
                                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400">...</span>
                                                </li>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            <li>
                                                <a href="{{ $pengumuman->url($i) }}"
                                                    class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $currentPage ? 'text-white bg-blue-600 border-blue-600' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-900' }} border">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor

                                        @if ($end < $lastPage)
                                            @if ($end < $lastPage - 1)
                                                <li>
                                                    <span
                                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400">...</span>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ $pengumuman->url($lastPage) }}"
                                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-900">
                                                    {{ $lastPage }}
                                                </a>
                                            </li>
                                        @endif
                                    @endif

                                    <!-- Next Button -->
                                    @if ($pengumuman->hasMorePages())
                                        <li>
                                            <a href="{{ $pengumuman->nextPageUrl() }}"
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-900">
                                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            @else
                <div class="px-6 py-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                        <i class="far fa-bell-slash text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada pengumuman</h3>
                    <p class="text-gray-500">Tidak ada pengumuman yang tersedia saat ini.</p>
                </div>
            @endif

            @if (!$showPagination && $pengumuman->isNotEmpty())
                <div class="bg-white px-6 py-4 border-t border-gray-200 text-center">
                    <a href="{{ route('pengumuman.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Lihat Semua Pengumuman
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
