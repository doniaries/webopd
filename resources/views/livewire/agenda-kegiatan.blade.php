<div class="space-y-4">
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h4 class="text-sm font-semibold text-gray-700 mb-2 sm:mb-0">
                    <i class="far fa-calendar-check text-green-600 mr-2"></i>
                    {{ $months[$currentMonth] }} {{ $currentYear }}
                </h4>
                <div class="flex items-center space-x-2">
                    <button wire:click="previousMonth" 
                            class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-green-600 transition-colors"
                            title="Bulan sebelumnya">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                    <button wire:click="nextMonth" 
                            class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-green-600 transition-colors"
                            title="Bulan berikutnya">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        
        @if(count($agendas) > 0)
            <div class="divide-y divide-gray-100">
                @foreach($agendas as $agenda)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start">
                            <div class="bg-green-50 p-3 rounded-lg mr-4">
                                <i class="fas fa-calendar-day text-green-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-800 mb-1">
                                    <a href="{{ route('agenda.show', $agenda->id) }}" 
                                       class="hover:text-green-600 transition-colors">
                                        {{ $agenda->nama_agenda }}
                                    </a>
                                </h4>
                                <div class="space-y-1.5 mt-2">
                                    <div class="flex items-start text-xs text-gray-600">
                                        <i class="far fa-clock mt-0.5 mr-2 text-green-500"></i>
                                        <div>
                                            <span class="font-medium">Waktu:</span>
                                            <span class="ml-1">
                                                {{ indonesia_date($agenda->dari_tanggal, true) }}
                                                @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                    - {{ indonesia_date($agenda->sampai_tanggal) }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @if ($agenda->tempat)
                                        <div class="flex items-start text-xs text-gray-600">
                                            <i class="fas fa-map-marker-alt mt-0.5 mr-2 text-green-500"></i>
                                            <div>
                                                <span class="font-medium">Lokasi:</span>
                                                <span class="ml-1">{{ $agenda->tempat }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($agenda->uraian_agenda)
                                        <div class="flex items-start text-xs text-gray-600">
                                            <i class="fas fa-info-circle mt-0.5 mr-2 text-green-500"></i>
                                            <div>
                                                <span class="font-medium">Keterangan:</span>
                                                <span class="ml-1 line-clamp-2">{{ $agenda->uraian_agenda }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($agenda->peserta)
                                        <div class="flex items-start text-xs text-gray-600">
                                            <i class="fas fa-users mt-0.5 mr-2 text-green-500"></i>
                                            <div>
                                                <span class="font-medium">Peserta:</span>
                                                <span class="ml-1">{{ $agenda->peserta }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($agenda->penyelenggara)
                                        <div class="flex items-start text-xs text-gray-600">
                                            <i class="fas fa-building mt-0.5 mr-2 text-green-500"></i>
                                            <div>
                                                <span class="font-medium">Penyelenggara:</span>
                                                <span class="ml-1">{{ $agenda->penyelenggara }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-3 flex justify-end">
                                    <a href="{{ route('agenda.show', $agenda->id) }}" 
                                       class="inline-flex items-center text-xs font-medium text-green-600 hover:text-green-800">
                                        Detail Agenda
                                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4 border-t border-gray-100 text-center">
                <a href="{{ route('agenda.index') }}" 
                   class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                    Lihat Semua Agenda
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50">
                <div class="text-gray-400 mb-2">
                    <i class="far fa-calendar-times text-4xl"></i>
                </div>
                <p class="text-sm text-gray-500">Tidak ada agenda untuk bulan ini</p>
                <a href="{{ route('agenda.index') }}" 
                   class="mt-2 inline-flex items-center text-xs text-green-600 hover:text-green-800">
                    Lihat agenda bulan lainnya
                </a>
            </div>
        @endif
        </div>
    </div>
</div>
