<div>
    <div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Informasi Terbaru</h4>
                </div>
                <div class="card-body">
                    @if ($informasi->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($informasi as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1"><a href="#" class="text-decoration-none text-dark">{{ $item->judul }}</a></h5>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $item->published_at->format('d M Y') }}
                                        </small>
                                        <p class="mb-0 mt-2">{{ Str::limit(strip_tags($item->isi), 150) }}</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-primary"></i>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            {{ $informasi->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                            Tidak ada informasi yang tersedia saat ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
