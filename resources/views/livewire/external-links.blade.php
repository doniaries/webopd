<!-- resources/views/livewire/external-links.blade.php -->
@if ($links->count() > 0)
    <section class="py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="text-white">Link Terkait</h2>
            </div>

            <div class="row justify-content-center">
                @foreach ($links as $link)
                    <div class="col-6 col-md-3 mb-4">
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                            class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                <div class="card-body text-center p-3">
                                    <div class="icon-wrapper mb-3">
                                        @if($link->icon)
                                            <i class="{{ $link->icon }} fa-2x text-primary"></i>
                                        @else
                                            <div class="default-logo">
                                                <span class="text-2xl font-bold text-primary">{{ substr($link->name, 0, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h6 class="card-title mb-0">{{ $link->name }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 10px;
                overflow: hidden;
                background: white;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
            }

            .icon-wrapper {
                width: 70px;
                height: 70px;
                margin: 0 auto 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(13, 110, 253, 0.1);
                border-radius: 50%;
                transition: all 0.3s ease;
            }

            .hover-lift:hover .icon-wrapper {
                background: rgba(13, 110, 253, 0.2);
                transform: scale(1.05);
            }

            .card {
                height: 100%;
                display: flex;
                flex-direction: column;
                border: none;
                transition: all 0.3s ease;
            }

            .card-body {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 1.5rem 1rem;
                justify-content: space-between;
            }

            .card-title {
                font-size: 0.9rem;
                font-weight: 600;
                margin-top: auto;
            }
        </style>
    @endpush
@endif
