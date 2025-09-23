<div>
    <x-page-header title="Agenda Kegiatan" />

    <!-- Agenda Detail Section -->
    <section id="agenda-detail" class="agenda-detail-section section">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('agenda.index') }}" class="btn btn-outline-secondary btn-sm mb-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Agenda
                            </a>

                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h1 class="h2 mb-0">{{ $agenda->nama_agenda }}</h1>
                                    @php
                                        $status = $agenda->status ?? 'Mendatang';
                                        $badgeClass = match ($status) {
                                            'Berlangsung' => 'badge bg-success',
                                            'Selesai' => 'badge bg-secondary',
                                            default => 'badge bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }} align-self-center">{{ $status }}</span>
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
    </section>
</div>
