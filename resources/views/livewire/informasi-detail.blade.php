<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $informasi->judul }}</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $informasi->published_at->format('d M Y') }}
                    </p>
                    <div class="informasi-content">
                        {!! $informasi->isi !!}
                    </div>
                    @if ($informasi->file)
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $informasi->file) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-download me-2"></i>Unduh File
                            </a>
                        </div>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Informasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
