<div class="w-full max-w-[320px] mx-auto rounded-lg shadow-md overflow-hidden relative bg-gray-100 group"
    style="width: 100%; max-width: 320px; height: 400px; position: relative;">
    <!-- Debug Info (can be removed later) -->
    @if (env('APP_DEBUG'))
        <div class="absolute top-0 left-0 bg-black/70 text-white text-xs p-2 z-50">
            Banners: {{ count($banners) }}
        </div>
    @endif

    <div class="swiper banner-slider absolute inset-0 w-full h-full">
        <div class="swiper-wrapper">
            @forelse ($banners as $banner)
                <div class="swiper-slide">
                    <div class="relative w-full h-full">
                        <a href="{{ $banner->url ?? '#' }}" class="block w-full h-full">
                            <img src="{{ $banner->gambar_url }}" alt="{{ $banner->judul ?? 'Banner' }}"
                                class="absolute inset-0 w-full h-full object-cover transition-all duration-300 ease-in-out hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder.jpg') }}'"
                                loading="lazy">
                        </a>

                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4 text-center"
                        style="aspect-ratio: 4/5;">
                        <i class="bi bi-image text-4xl mb-4"></i>
                        <p class="text-lg">Tidak ada banner tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Navigation Buttons -->
    @if (count($banners) > 1)
        <div class="swiper-button-prev">
            <i class="bi bi-chevron-left"></i>
        </div>
        <div class="swiper-button-next">
            <i class="bi bi-chevron-right"></i>
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    @endif
</div>

@push('styles')
    <style>
        .swiper-slide {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .swiper-slide a {
            display: block;
            width: 100%;
            height: 100%;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* Navigation buttons */
        .swiper-button-prev,
        .swiper-button-next {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.021);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #080808;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .swiper:hover .swiper-button-prev,
        .swiper:hover .swiper-button-next {
            opacity: 1;
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            background: rgba(51, 50, 50, 0.842);
            transform: scale(1.1);
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-button-next {
            right: 10px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {

            .swiper-button-prev,
            .swiper-button-next {
                width: 30px;
                height: 30px;
                font-size: 14px;
                opacity: 0.7;
            }

            .swiper-button-prev {
                left: 5px;
            }

            .swiper-button-next {
                right: 5px;
            }

            /* Tambahkan CSS berikut untuk responsivitas mobile */
            .banner-slider,
            .swiper-slide {
                width: 100% !important;
                height: auto !important;
            }

            .swiper-slide a,
            .swiper-slide img {
                position: relative !important;
                height: auto !important;
                aspect-ratio: 4/5;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            const bannerSwiper = new Swiper('.banner-slider', {
                // Navigation
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                // Pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                // Effects
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                // Autoplay
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                // General settings
                loop: {{ count($banners ?? []) > 1 ? 'true' : 'false' }},
                speed: 800,

                grabCursor: true,
                preloadImages: true,
                updateOnWindowResize: true,
                watchSlidesProgress: true,
                preventClicks: true,
                preventClicksPropagation: true,
            });

            // Pause autoplay when hovering over the banner
            const bannerContainer = document.querySelector('.banner-slider');
            if (bannerContainer) {
                bannerContainer.addEventListener('mouseenter', () => {
                    if (bannerSwiper.autoplay && bannerSwiper.autoplay.running) {
                        bannerSwiper.autoplay.stop();
                    }
                });

                bannerContainer.addEventListener('mouseleave', () => {
                    if (bannerSwiper.autoplay && !bannerSwiper.autoplay.running) {
                        bannerSwiper.autoplay.start();
                    }
                });
            }
        });
    </script>
@endpush
