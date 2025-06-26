<div class="w-full mx-auto rounded-lg shadow-md overflow-hidden h-[600px] md:h-[500px] lg:h-[600px] xl:h-[700px] relative">
    <div class="swiper banner-slider h-full">
        <div class="swiper-wrapper h-full">
            @forelse ($banners as $banner)
                <div class="swiper-slide h-full">
                    <div class="relative w-full h-full overflow-hidden group">
                        @php
                            // Menggunakan Storage URL untuk menampilkan gambar
                            $imagePath = $banner->gambar ? \Illuminate\Support\Facades\Storage::url($banner->gambar) : '';
                        @endphp
                        
                        <a href="{{ $banner->url ?? '#' }}" class="block w-full h-full">
                            <img src="{{ $imagePath }}" 
                                 alt="{{ $banner->judul }}" 
                                 class="w-full h-full object-cover transition-all duration-700 ease-in-out transform hover:scale-110">
                        </a>
                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-500 p-8 text-center">
                        <i class="bi bi-image text-4xl mb-4"></i>
                        <p class="text-lg">Tidak ada banner tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-next bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300"></div>
        <div class="swiper-button-prev bg-black/50 hover:bg-black/70 w-10 h-10 md:w-12 md:h-12 rounded-full transition-all duration-300"></div>
        <!-- Pagination -->
        <div class="swiper-pagination !bottom-4"></div>
    </div>
</div>

@push('styles')
<style>
    /* Swiper Navigation Customization */
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 1.2rem;
        font-weight: bold;
        color: white;
    }

    /* Pagination Bullets */
    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.5);
        opacity: 1;
        width: 10px;
        height: 10px;
        margin: 0 5px !important;
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
