<div class="max-w-4xl mx-auto">
    <!-- Header with Month Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-bold text-dark flex items-center">
                    <i class="far fa-calendar-alt mr-3"></i>
                    {{ $months[$currentMonth] }} {{ $currentYear }}
                </h2>
                <div class="flex items-center space-x-2 mt-3 sm:mt-0">
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
        </div>

        @if (count($agendas) > 0)
            <div class="divide-y divide-gray-100">
                @foreach ($agendas as $agenda)
                    <div class="p-5 hover:bg-gray-50 transition-colors duration-200 group">
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- Date Badge -->
                            <div class="flex-shrink-0">
                                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-3 w-20 text-center">
                                    <div class="text-emerald-700 font-bold text-lg leading-tight">
                                        {{ \Carbon\Carbon::parse($agenda->dari_tanggal)->format('d') }}
                                    </div>
                                    <div class="text-emerald-500 text-xs font-medium uppercase">
                                        {{ substr($months[\Carbon\Carbon::parse($agenda->dari_tanggal)->format('n')], 0, 3) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Agenda Content -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">
                                        <a href="{{ route('agenda.show', $agenda->id) }}" class="hover:underline">
                                            {{ $agenda->nama_agenda }}
                                        </a>
                                    </h3>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $agenda->kategori ?? 'Umum' }}
                                    </span>
                                </div>

                                <div class="mt-2 space-y-2">
                                    <!-- Time -->
                                    <div class="flex items-start text-sm text-gray-600">
                                        <i class="far fa-clock mt-1 mr-2 text-emerald-500 w-4 text-center"></i>
                                        <div>
                                            <span class="font-medium text-gray-700">Waktu:</span>
                                            <span class="ml-1">
                                                {{ indonesia_date($agenda->dari_tanggal, true) }}
                                                @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                    - {{ indonesia_date($agenda->sampai_tanggal) }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    @if ($agenda->tempat)
                                        <div class="flex items-start text-sm text-gray-600">
                                            <i
                                                class="fas fa-map-marker-alt mt-1 mr-2 text-emerald-500 w-4 text-center"></i>
                                            <div>
                                                <span class="font-medium text-gray-700">Lokasi:</span>
                                                <span class="ml-1">{{ $agenda->tempat }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Description -->
                                    @if ($agenda->uraian_agenda)
                                        <div class="text-sm text-gray-600 line-clamp-2">
                                            {{ $agenda->uraian_agenda }}
                                        </div>
                                    @endif

                                    <!-- Additional Info -->
                                    <div class="flex flex-wrap gap-4 mt-2 pt-2 border-t border-gray-100">
                                        @if ($agenda->peserta)
                                            <div class="flex items-center text-xs text-gray-500">
                                                <i class="fas fa-users mr-1.5 text-emerald-500"></i>
                                                {{ $agenda->peserta }}
                                            </div>
                                        @endif

                                        @if ($agenda->penyelenggara)
                                            <div class="flex items-center text-xs text-gray-500">
                                                <i class="fas fa-building mr-1.5 text-emerald-500"></i>
                                                {{ $agenda->penyelenggara }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <a href="{{ route('agenda.show', $agenda->id) }}"
                                        class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-800 group-hover:underline">
                                        Lihat Detail
                                        <i
                                            class="fas fa-arrow-right ml-1.5 text-xs transition-transform group-hover:translate-x-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <a href="{{ route('agenda.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Lihat Semua Agenda
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 px-6">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-emerald-50 mb-4">
                    <i class="far fa-calendar-times text-3xl text-emerald-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada agenda</h3>
                <p class="text-gray-500 mb-4">Tidak ada agenda yang dijadwalkan untuk bulan ini.</p>
                <a href="{{ route('agenda.index') }}"
                    class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-800">
                    Lihat agenda bulan lainnya
                    <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                </a>
            </div>
        @endif
    </div>
</div>
