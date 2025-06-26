<div class="w-full max-w-[320px] mx-auto rounded-lg shadow-md overflow-hidden relative bg-gray-100 group" style="aspect-ratio: 4/5;">
    <div class="swiper banner-slider h-full">
        <div class="swiper-wrapper h-full">
            @forelse ($banners as $banner)
                <div class="swiper-slide h-full">
                    <div class="relative w-full h-full overflow-hidden group">
                        <div class="relative w-full h-full">
                            <a href="{{ $banner->url ?? '#' }}" class="block w-full h-full">
                                <img 
                                    src="{{ $banner->image_url }}" 
                                    alt="{{ $banner->judul }}"
                                    class="w-full h-full object-cover rounded-lg transition-all duration-300 ease-in-out hover:scale-105"
                                    style="aspect-ratio: 4/5;"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/default-banner.jpg') }}'"
                                    loading="lazy"
                                >
                            </a>
                            @if($banner->keterangan)
                                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent text-white">
                                    <h3 class="font-semibold text-sm line-clamp-2">{{ $banner->judul }}</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div
                        class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4 text-center" style="aspect-ratio: 4/5;">
                        <i class="bi bi-image text-4xl mb-4"></i>
                        <p class="text-lg">Tidak ada banner tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Navigation buttons - Only show when there are banners -->
        @if(count($banners ?? []) > 1)
            <div class="swiper-button-next opacity-0 group-hover:opacity-100 bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300">
            </div>
            <div class="swiper-button-prev opacity-0 group-hover:opacity-100 bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300">
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination !bottom-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        @endif
    </div>
</div>

@push('styles')
    <style>
        /* Swiper Navigation Customization */
        .swiper-button-next,
        .swiper-button-prev {
            transform: translateY(-50%) scale(0.8);
            transition: all 0.3s ease;
        }
        
        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
        }
        
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            transform: translateY(-50%) scale(0.9);
        }

        /* Pagination Bullets */
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            width: 8px;
            height: 8px;
            margin: 0 4px !important;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: #fff;
            width: 30px;
            border-radius: 5px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {

            .swiper-button-next,
            .swiper-button-prev {
                width: 32px !important;
                height: 32px !important;
            }

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            const bannerSwiper = new Swiper('.banner-slider', {
                loop: {{ count($banners ?? []) > 1 ? 'true' : 'false' }},
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 800,
                grabCursor: true,
                preloadImages: true,
                updateOnWindowResize: true,
                watchSlidesProgress: true,
                preventClicks: false,
                preventClicksPropagation: false,
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
