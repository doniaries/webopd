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

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari pengumuman..."
                                            wire:model.live.debounce.300ms="search">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="month" class="form-control" wire:model.live="bulan" 
                                        max="{{ now()->format('Y-m') }}">
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-outline-secondary w-100" wire:click="$set('bulan', '')">
                                        Reset Filter
                                    </button>
                                </div>
                            </div>

                            <div id="pengumuman-list">
                                @if (isset($pengumuman) && count($pengumuman) > 0)
                                    <div class="row g-3">
                                        @foreach ($pengumuman as $item)
                                            <div class="col-md-6">
                                                <div class="bg-blue-50 rounded-lg p-3 border-l-4 border-blue-600 shadow-sm h-100">
                                                    <div class="flex items-start">
                                                        <div class="flex-shrink-0 mr-3">
                                                            <div class="p-2 bg-blue-600 text-white rounded-full">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="{{ route('pengumuman.show', $item->slug) }}" class="font-bold text-gray-800 hover:text-blue-600 transition-colors">{{ $item->judul }}</a>
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                {{ $item->published_at->format('d M Y') }}
                                                            </div>
                                                            <div class="mt-2 text-sm text-gray-600">
                                                                {{ Str::limit(strip_tags($item->isi), 100) }}
                                                            </div>
                                                            @if ($item->file)
                                                                <div class="mt-2">
                                                                    <span class="text-xs text-blue-600">
                                                                        <i class="bi bi-paperclip me-1"></i>
                                                                        Memiliki lampiran
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            <div class="mt-2 text-right">
                                                                <a href="{{ route('pengumuman.show', $item->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                                    Baca selengkapnya <i class="bi bi-arrow-right"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-6 text-center">
                                        <div class="mx-auto bg-gray-100 rounded-full p-3 w-16 h-16 flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h5 class="text-lg font-bold text-gray-800">Tidak ada pengumuman</h5>
                                        <p class="text-gray-500 mt-2">Tidak ada pengumuman yang ditemukan.</p>
                                    </div>
                                @endif
                            </div>

                            @if(isset($pengumuman) && method_exists($pengumuman, 'links') && $pengumuman->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted small">
                                        Menampilkan {{ $pengumuman->firstItem() }} - {{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }} pengumuman
                                    </div>
                                    <div>
                                        {{ $pengumuman->onEachSide(1)->links() }}
                                    </div>
                                </div>
                            @elseif(isset($pengumuman) && $pengumuman->isEmpty())
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-info-circle text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="text-muted">Tidak ada pengumuman yang ditemukan</h5>
                                    @if($search || $bulan)
                                        <p class="text-muted">Coba hapus filter pencarian atau bulan untuk melihat semua pengumuman</p>
                                        <button class="btn btn-outline-primary mt-2" wire:click="$set('search', ''); $set('bulan', '')">
                                            Hapus Semua Filter
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
