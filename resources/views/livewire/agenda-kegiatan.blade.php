<div>
    <x-page-header title="Agenda Kegiatan" />

    <!-- Agenda Section -->
    <section id="agenda" class="agenda-section section">
        <div class="container" data-aos="fade-up">
            {{-- <div class="section-title">
                <h2>Agenda Kegiatan</h2>
                <p>Jadwal kegiatan terbaru</p>
            </div> --}}

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $months[$currentMonth] }} {{ $currentYear }}</h3>
                        </div>
                        <div class="d-flex">
                            <button wire:click="previousMonth" class="btn btn-outline-primary btn-sm me-2">
                                <i class="bi bi-chevron-left"></i> Bulan Sebelumnya
                            </button>
                            <button wire:click="nextMonth" class="btn btn-outline-primary btn-sm">
                                Bulan Depan <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if ($view === 'index')
                <div class="row">
                    @forelse($agendas as $agenda)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                            <i class="bi bi-calendar-event text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title">{{ $agenda->nama_agenda }}</h5>
                                            <p class="card-text text-muted small">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($agenda->dari_tanggal)->translatedFormat('l, d F Y') }}
                                                @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                    -
                                                    {{ \Carbon\Carbon::parse($agenda->sampai_tanggal)->translatedFormat('d F Y') }}
                                                @endif
                                            </p>
                                            <p class="card-text">
                                                {{ Str::limit($agenda->uraian_agenda, 120) }}
                                            </p>
                                            <button wire:click="showAgenda({{ $agenda->id }})"
                                                class="btn btn-link p-0">
                                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="bi bi-info-circle me-2"></i>
                                <h5 class="d-inline">Tidak ada agenda</h5>
                                <p class="mb-0">Tidak ada agenda yang dijadwalkan untuk bulan ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($agendas->hasPages())
                    <div class="row mt-4">
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                {{ $agendas->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
            @else
                <!-- Detail View -->
                <div class="card">
                    <div class="card-body">
                        <button wire:click="$set('selectedAgenda', null)" class="btn btn-outline-secondary btn-sm mb-4">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Agenda
                        </button>

                        <div class="mb-4">
                            <h1 class="h2 mb-3">{{ $selectedAgenda->nama_agenda }}</h1>
                            <div class="d-flex align-items-center text-muted mb-3">
                                <i class="bi bi-calendar-event me-2"></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($selectedAgenda->dari_tanggal)->translatedFormat('l, d F Y') }}
                                    @if ($selectedAgenda->sampai_tanggal && $selectedAgenda->sampai_tanggal != $selectedAgenda->dari_tanggal)
                                        -
                                        {{ \Carbon\Carbon::parse($selectedAgenda->sampai_tanggal)->translatedFormat('d F Y') }}
                                    @endif
                                </span>
                            </div>

                            @if ($selectedAgenda->tempat)
                                <div class="d-flex align-items-center text-muted mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    <span>{{ $selectedAgenda->tempat }}</span>
                                </div>
                            @endif

                            @if ($selectedAgenda->waktu)
                                <div class="d-flex align-items-center text-muted mb-4">
                                    <i class="bi bi-clock me-2"></i>
                                    <span>{{ $selectedAgenda->waktu }}</span>
                                </div>
                            @endif

                            <div class="border-top pt-3">
                                <h5 class="mb-3">Deskripsi Kegiatan</h5>
                                <div class="content">
                                    {!! $selectedAgenda->uraian_agenda !!}
                                </div>
                            </div>

                            @if ($selectedAgenda->lampiran)
                                <div class="border-top pt-3 mt-4">
                                    <h5 class="mb-3">Lampiran</h5>
                                    <a href="{{ asset('storage/' . $selectedAgenda->lampiran) }}" target="_blank"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-download me-2"></i> Unduh Lampiran
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
