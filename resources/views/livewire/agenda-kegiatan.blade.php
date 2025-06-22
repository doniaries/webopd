<div>
    <x-page-header title="Agenda Kegiatan" />

    <!-- Agenda Section -->
    <section id="agenda" class="agenda-section section">
        <div class="container" data-aos="fade-up">
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
                                        <h5 class="card-title">
                                            <a href="{{ route('agenda.show', $agenda->id) }}" class="text-dark text-decoration-none">
                                                {{ $agenda->nama_agenda }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($agenda->dari_tanggal)->translatedFormat('l, d F Y') }}
                                            @if ($agenda->sampai_tanggal && $agenda->sampai_tanggal != $agenda->dari_tanggal)
                                                -
                                                {{ \Carbon\Carbon::parse($agenda->sampai_tanggal)->translatedFormat('d F Y') }}
                                            @endif
                                        </p>
                                        @if ($agenda->tempat)
                                            <p class="card-text text-muted small mb-2">
                                                <i class="bi bi-geo-alt me-1"></i> {{ $agenda->tempat }}
                                            </p>
                                        @endif
                                        <p class="card-text">
                                            {{ Str::limit($agenda->uraian_agenda, 120) }}
                                        </p>
                                        <a href="{{ route('agenda.show', $agenda->id) }}" class="btn btn-link p-0">
                                            Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
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
        </div>
    </section>
</div>
