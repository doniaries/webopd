<div>
    <x-page-header :title="$agenda->nama_agenda" />
    
    <div class="py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <a href="{{ route('agenda.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Agenda
                        </a>

                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $agenda->nama_agenda }}</h1>
                                    <div class="mt-2">
                                        @php
                                            $status = $agenda->status ?? 'Mendatang';
                                            $badgeClass = match ($status) {
                                                'Berlangsung' => 'bg-green-100 text-green-800',
                                                'Selesai' => 'bg-gray-100 text-gray-800',
                                                default => 'bg-yellow-100 text-yellow-800',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                                            {{ $status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        <span>
                                            {{ indonesia_date($agenda->dari_tanggal, true) }}
                                            @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                s.d. {{ indonesia_date($agenda->sampai_tanggal, true) }}
                                            @endif
                                        </span>
                                    </div>
                                    
                                    @if ($agenda->waktu_mulai)
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="bi bi-clock me-2"></i>
                                            <span>
                                                {{ indonesia_time($agenda->waktu_mulai) }}
                                                @if ($agenda->waktu_selesai)
                                                    - {{ indonesia_time($agenda->waktu_selesai) }} WIB
                                                @else
                                                    WIB
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    @if ($agenda->tempat)
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="bi bi-geo-alt me-2"></i>
                                            <span>{{ $agenda->tempat }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="border-top pt-3">
                                    <h5 class="mb-3">Deskripsi Kegiatan</h5>
                                    <div class="content">
                                        {!! $agenda->uraian_agenda !!}
                                    </div>
                                </div>

                                @if ($agenda->lampiran)
                                    <div class="border-top pt-3 mt-4">
                                        <h5 class="mb-3">Lampiran</h5>
                                        <a href="{{ asset('storage/' . $agenda->lampiran) }}" target="_blank"
                                            class="btn btn-outline-primary">
                                            <i class="bi bi-download me-2"></i> Unduh Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
