<div style="width:300px; height:350px; display:block; margin:auto;">
    <div class="banner-swiper w-full h-full">
        <div class="banner-swiper-wrapper swiper-wrapper">
            @forelse ($banners as $banner)
                <div class="banner-swiper-slide swiper-slide">
                    <a href="{{ $banner->url ?? '#' }}" style="width:300px; height:350px; display:block;">
                        <img src="{{ $banner->image_url }}" alt="Banner"
                            style="width:300px; height:350px; object-fit:cover; object-position:center; display:block; border:none; margin:0; padding:0; box-shadow:none; background:none;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder2.jpg') }}'"
                            loading="lazy">
                    </a>
                </div>
            @empty
                <div class="banner-swiper-slide swiper-slide">
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4 text-center"
                        style="width:300px; height:350px;">
                        <i class="bi bi-image text-4xl mb-4"></i>
                        <p class="text-lg">Tidak ada banner tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if (count($banners ?? []) > 1)
            <div
                class="banner-swiper-button-next bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300">
            </div>
            <div
                class="banner-swiper-button-prev bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300">
            </div>
            <div class="banner-swiper-pagination !bottom-2 transition-opacity duration-300"></div>
        @endif
    </div>
</div>

@push('styles')
    <style>
        .banner-swiper {
            min-height: 350px;
            max-width: 300px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .banner-swiper .banner-swiper-wrapper {
            max-width: 300px;
        }

        .banner-swiper-slide {
            width: 100% !important;
            max-width: 300px;
            min-height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner-swiper-button-next,
        .banner-swiper-button-prev {
            transform: translateY(-50%) scale(0.8);
            transition: all 0.3s ease;
        }

        .banner-swiper-button-next:after,
        .banner-swiper-button-prev:after {
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
        }

        .banner-swiper-button-next:hover,
        .banner-swiper-button-prev:hover {
            transform: translateY(-50%) scale(0.9);
        }

        .banner-swiper-pagination .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            width: 8px;
            height: 8px;
            margin: 0 4px !important;
            transition: all 0.3s ease;
        }

        .banner-swiper-pagination .swiper-pagination-bullet-active {
            background: #fff;
            width: 30px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {

            .banner-swiper-button-next,
            .banner-swiper-button-prev {
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
            const bannerSwiper = new Swiper('.banner-swiper', {
                loop: {{ count($banners ?? []) > 1 ? 'true' : 'false' }},
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                speed: 800,
                pagination: {
                    el: '.banner-swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.banner-swiper-button-next',
                    prevEl: '.banner-swiper-button-prev',
                },
                grabCursor: true,
                preloadImages: true,
                updateOnWindowResize: true,
                watchSlidesProgress: true,
                preventClicks: true,
                preventClicksPropagation: true,
            });
        });
    </script>
@endpush
