<div>
    @push('styles')
    <style>
        @keyframes flash {
            0% { background-color: rgba(254, 202, 202, 0.8); }
            100% { background-color: transparent; }
        }
        
        .flash-effect {
            animation: flash 1.5s ease-out;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
    @endpush

    @if ($view === 'show' && $pengumuman)
        <div class="container py-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h1 class="card-title h3">{{ $pengumuman->judul }}</h1>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-muted small">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $pengumuman->published_at->format('d M Y') }}
                                </div>
                            </div>
                            <div class="card-text mb-4">
                                {!! $pengumuman->isi !!}
                            </div>

                            @if ($pengumuman->file)
                                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                    <a href="{{ asset('storage/' . $pengumuman->file) }}" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-download me-1"></i>
                                        Unduh Lampiran
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container py-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h1 class="card-title h3 mb-4">Pengumuman</h1>

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari pengumuman..."
                                        wire:model.live.debounce.300ms="search">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="list-group" id="pengumuman-list">
                                @if (isset($pengumuman) && count($pengumuman) > 0)
                                    @foreach ($pengumuman as $item)
                                        <a href="{{ route('pengumuman.show', $item->slug) }}"
                                            class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $item->judul }}</h5>
                                                <small>{{ $item->published_at->format('d M Y') }}</small>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if ($item->file)
                                                    <small class="text-muted">
                                                        <i class="bi bi-paperclip me-1"></i>
                                                        Memiliki lampiran
                                                    </small>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Tidak ada pengumuman</h5>
                                        </div>
                                        <p class="mb-1">Tidak ada pengumuman yang ditemukan.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                @if(isset($pengumuman) && method_exists($pengumuman, 'links'))
                                    {{ $pengumuman->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
