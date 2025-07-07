<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Daftar Seluruh Agenda</h2>
            <p class="text-lg text-gray-600">Jadwal dan informasi kegiatan terbaru</p>
        </div>

        <div
            class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl shadow-lg overflow-hidden border border-green-200">
            @if (count($agendas) > 0)
                <div class="w-full overflow-x-auto">
                    <table class="w-full table-auto divide-y divide-green-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th scope="col"
                                    class="w-12 px-2 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-hashtag"></i>
                                </th>
                                <th scope="col"
                                    class="min-w-[250px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="far fa-calendar-alt mr-2"></i>Nama Kegiatan
                                </th>
                                <th scope="col"
                                    class="min-w-[150px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Lokasi
                                </th>
                                <th scope="col"
                                    class="min-w-[120px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="far fa-calendar mr-2"></i>Tanggal
                                </th>
                                <th scope="col"
                                    class="min-w-[100px] px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="far fa-clock mr-2"></i>Waktu
                                </th>
                                <th scope="col"
                                    class="w-24 px-2 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-1"></i>Detail
                                </th>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($agendas as $index => $agenda)
                                <tr
                                    class="hover:bg-green-50 transition-colors duration-200 {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-2 py-3 text-center text-sm text-gray-700 font-medium">
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-800 text-xs">
                                            {{ ($agendas->currentPage() - 1) * $agendas->perPage() + $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-day text-green-500 text-lg mr-2"></i>
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $agenda->nama_agenda }}</div>
                                                <div class="text-xs text-gray-500 truncate">{{ $agenda->penyelenggara }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-green-500 mr-2 flex-shrink-0"></i>
                                            <span class="truncate">{{ $agenda->tempat ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="far fa-calendar text-green-500 mr-2 flex-shrink-0"></i>
                                            <span>
                                                {{ indonesia_date($agenda->dari_tanggal, true) }}
                                                @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                    <span class="whitespace-nowrap">-
                                                        {{ indonesia_date($agenda->sampai_tanggal, false) }}</span>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="far fa-clock text-green-500 mr-2 flex-shrink-0"></i>
                                            <span>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 text-sm font-medium text-center">
                                        <a href="{{ route('agenda.show', $agenda->id) }}"
                                            class="inline-flex items-center justify-center w-full px-2 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                            <i class="far fa-eye mr-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-medium">{{ $agendas->firstItem() }}</span> sampai 
                            <span class="font-medium">{{ $agendas->lastItem() }}</span> dari 
                            <span class="font-medium">{{ $agendas->total() }}</span> hasil
                        </div>
                        
                        <nav aria-label="Page navigation">
                            <ul class="inline-flex -space-x-px text-sm">
                                <!-- Previous Button -->
                                @if ($agendas->onFirstPage())
                                    <li>
                                        <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                                            Sebelumnya
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <button wire:click="previousPage" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                            Sebelumnya
                                        </button>
                                    </li>
                                @endif
                                
                                <!-- Page Numbers -->
                                @php
                                    $current = $agendas->currentPage();
                                    $last = $agendas->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);
                                    
                                    if ($start > 1) {
                                        echo '<li><button wire:click="gotoPage(1)" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</button></li>';
                                        if ($start > 2) echo '<li><span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500">...</span></li>';
                                    }
                                    
                                    for ($i = $start; $i <= $end; $i++) {
                                        if ($i == $current) {
                                            echo '<li><span class="flex items-center justify-center px-3 h-8 text-white border border-green-600 bg-green-600">' . $i . '</span></li>';
                                        } else {
                                            echo '<li><button wire:click="gotoPage(' . $i . ')" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">' . $i . '</button></li>';
                                        }
                                    }
                                    
                                    if ($end < $last) {
                                        if ($end < $last - 1) echo '<li><span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500">...</span></li>';
                                        echo '<li><button wire:click="gotoPage(' . $last . ')" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">' . $last . '</button></li>';
                                    }
                                @endphp
                                
                                <!-- Next Button -->
                                @if ($agendas->hasMorePages())
                                    <li>
                                        <button wire:click="nextPage" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                            Selanjutnya
                                        </button>
                                    </li>
                                @else
                                    <li>
                                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                                            Selanjutnya
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                        <i class="far fa-calendar-times text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada agenda</h3>
                    <p class="text-gray-500">Tidak ada agenda yang dijadwalkan untuk bulan ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
