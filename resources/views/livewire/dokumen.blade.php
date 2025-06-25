<div>
    <x-page-header title="Dokumen" />

    <!-- Dokumen Section -->
    <section id="dokumen" class="dokumen-section section">
        <div class="container" data-aos="fade-up">
            <div class="row">
                @if($dokumens && $dokumens->count() > 0)
                    @foreach($dokumens as $dokumen)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm hover:shadow-md transition-shadow">
                                @if($dokumen->cover)
                                    <img src="{{ asset('storage/' . $dokumen->cover) }}" class="card-img-top" alt="{{ $dokumen->nama_dokumen }}">
                                @else
                                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                                        <i class="bi bi-file-earmark-text text-gray-400 text-5xl"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title font-semibold text-lg mb-2">{{ $dokumen->nama_dokumen }}</h5>
                                    <p class="card-text text-sm text-gray-600 mb-3 line-clamp-3">{{ $dokumen->deskripsi }}</p>
                                    <div class="d-flex justify-content-between align-items-center text-xs text-gray-500 mb-3">
                                        <span><i class="bi bi-calendar me-1"></i> {{ $dokumen->tahun_terbit }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center text-xs mb-3">
                                        <span class="badge bg-info text-white">
                                            <i class="bi bi-eye me-1"></i> Dilihat: {{ number_format($dokumen->views) }} kali
                                        </span>
                                        <span class="badge bg-success text-white">
                                            <i class="bi bi-download me-1"></i> Diunduh: {{ number_format($dokumen->downloads) }} kali
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button wire:click="incrementViews({{ $dokumen->id }})" 
                                                class="btn btn-sm btn-outline-primary" 
                                                onclick="window.open('{{ asset('storage/' . $dokumen->file) }}', '_blank')">
                                            <i class="bi bi-eye me-1"></i> Lihat
                                        </button>
                                        <button wire:click="incrementDownloads({{ $dokumen->id }})" 
                                                class="btn btn-sm btn-primary" 
                                                onclick="window.location.href='{{ asset('storage/' . $dokumen->file) }}'">
                                            <i class="bi bi-download me-1"></i> Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> Belum ada dokumen yang tersedia.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
