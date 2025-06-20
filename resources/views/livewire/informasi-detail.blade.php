<div>
    <div class="container-fluid py-5 bg-light">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                    <div class="position-relative">
                        <div class="card-header bg-gradient-primary text-white py-4 border-0">
                            <h2 class="mb-0 fw-bold text-center text-white">{{ $informasi->judul }}</h2>
                            <div class="position-absolute bottom-0 start-0 w-100 bg-gradient-dark" style="height: 3px;">
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-calendar3 text-primary"></i>
                            </div>
                            <span class="text-muted">
                                {{ $informasi->published_at->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>

                        <div class="informasi-content prose prose-lg">
                            {!! $informasi->isi !!}
                        </div>

                        @if ($informasi->file)
                            <div class="mt-5 d-flex justify-content-center">
                                <a href="{{ asset('storage/' . $informasi->file) }}" target="_blank"
                                    class="btn btn-primary btn-lg px-5 d-flex align-items-center">
                                    <i class="bi bi-cloud-download me-2 fs-5"></i>
                                    Unduh Lampiran
                                </a>
                            </div>
                        @endif

                        <div class="mt-5 pt-4 border-top">
                            <a href="{{ route('informasi.index') }}"
                                class="btn btn-outline-secondary d-flex align-items-center w-fit-content">
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali ke Daftar Informasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #2937f0, #9f1ae2) !important;
        }

        .bg-gradient-dark {
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
        }

        .w-fit-content {
            width: fit-content;
        }

        .prose {
            line-height: 1.8;
            color: #374151;
        }

        .prose p {
            margin-bottom: 1.5rem;
        }

        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 2rem 0;
        }
    </style>
</div>
