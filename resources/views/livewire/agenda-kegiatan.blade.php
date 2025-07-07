<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Agenda Kegiatan</h2>
            <p class="text-lg text-gray-600">Jadwal dan informasi kegiatan terbaru</p>
        </div>

        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl shadow-lg overflow-hidden border border-green-200">
            <!-- Month Navigation -->
            <div class="px-6 py-4 bg-green-600 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="far fa-calendar-alt mr-2"></i>
                    {{ $months[$currentMonth] }} {{ $currentYear }}
                </h3>
                <div class="flex space-x-2">
                    <button wire:click="previousMonth" 
                            class="p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all duration-200"
                            title="Bulan sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button wire:click="nextMonth" 
                            class="p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all duration-200"
                            title="Bulan berikutnya">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            @if (count($agendas) > 0)
                <div class="w-full">
                    <table class="w-full divide-y divide-green-200 table-fixed">
                        <thead class="bg-green-600">
                            <tr>
                                <th scope="col" class="w-12 px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    <i class="fas fa-hashtag"></i>
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/5">
                                    <i class="far fa-calendar-alt mr-2"></i>Nama Kegiatan
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Lokasi
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                    <i class="far fa-clock mr-2"></i>Waktu
                                </th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-1/6">
                                    <i class="fas fa-info-circle mr-1"></i>Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($agendas as $index => $agenda)
                                <tr class="hover:bg-green-50 transition-colors duration-200 {{ $index % 2 === 0 ? 'bg-white' : 'bg-green-50' }}">
                                    <td class="px-3 py-3 text-center text-sm text-gray-700 font-medium w-12">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-800 text-xs">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap w-2/5">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-day text-green-500 text-lg mr-3"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $agenda->nama_agenda }}</div>
                                                @if ($agenda->kategori)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                                        {{ $agenda->kategori }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap w-1/6 text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                            <span class="truncate">{{ $agenda->tempat ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap w-1/6">
                                        <div class="text-sm text-gray-700">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar-alt text-green-500 mr-2"></i>
                                                <span>{{ indonesia_date($agenda->dari_tanggal, true) }}</span>
                                            </div>
                                            @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                <div class="text-xs text-gray-500 ml-6">
                                                    s/d {{ indonesia_date($agenda->sampai_tanggal, false) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap w-1/6 text-sm font-medium text-center">
                                        <a href="{{ route('agenda.show', $agenda->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                            <i class="far fa-eye mr-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-green-600 px-6 py-4 flex items-center justify-between border-t border-green-500">
                    <div class="text-sm text-white">
                        <i class="far fa-calendar-alt mr-2"></i>
                        Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }} dari {{ $agendas->total() }} agenda
                    </div>
                    <div class="flex-1 flex justify-end">
                        {{ $agendas->links() }}
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
