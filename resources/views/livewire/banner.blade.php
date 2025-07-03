<div class="w-full max-w-[320px] mx-auto rounded-lg shadow-md overflow-hidden relative bg-gray-100 group"
    style="aspect-ratio: 4/5; width: 100%; height: 100%;">
    @if (env('APP_DEBUG'))
        <div class="absolute top-0 left-0 bg-black/70 text-white text-xs p-2 z-50">
            Banners: {{ count($banners) }}
        </div>
    @endif

    <div class="swiper banner-slider w-full h-full">
        <div class="swiper-wrapper">
            @forelse ($banners as $banner)
                <div class="swiper-slide flex justify-center items-center">
                    <div
                        class="w-full max-w-[320px] aspect-[4/5] bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center">
                        <a href="{{ $banner->url ?? '#' }}" class="block w-full h-full">
                            <img src="{{ $banner->gambar_url }}" alt="{{ $banner->judul ?? 'Banner' }}"
                                class="w-full h-full object-cover transition-all duration-300 ease-in-out hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder2.jpg') }}'"
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
        @if (count($banners ?? []) > 1)
            <div
                class="swiper-button-next bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300">
            </div>
            <div
                class="swiper-button-prev bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300">
            </div>
            <div class="swiper-pagination !bottom-2 transition-opacity duration-300">
            </div>
        @endif
    </div>
</div>

@push('styles')
    <style>
        .banner-slider {
            min-height: 320px;
            max-width: 320px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .banner-slider .swiper-wrapper {
            max-width: 320px;
        }

        .swiper-slide {
            width: 100% !important;
            max-width: 320px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

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

        @media (max-width: 768px) {

            .swiper-button-next,
            .swiper-button-prev {
                width: 32px !important;
                height: 32px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bannerSwiper = new Swiper('.banner-slider', {
                loop: {{ count($banners ?? []) > 1 ? 'true' : 'false' }},
                
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                speed: 800,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                grabCursor: true,
                preloadImages: true,
                updateOnWindowResize: true,
                watchSlidesProgress: true,
                preventClicks: true,
                preventClicksPropagation: true,
            });
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
