<div>
    <div class="swiper-container">
        <!-- Swiper Wrapper -->
        <div class="swiper-wrapper">
            @forelse($banners as $banner)
                <div class="swiper-slide">
                    <div class="relative aspect-[16/9] overflow-hidden rounded-lg">
                        <img src="{{ $banner->image_url }}" alt="Banner {{ $loop->index + 1 }}"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                            loading="lazy">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-opacity duration-300">
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="text-center py-4 text-gray-500">
                        Tidak ada banner tersedia
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    @push('styles')
        <style>
            .swiper-container {
                width: 100%;
                height: 100%;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .swiper-button-next,
            .swiper-button-prev {
                color: #fff;
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                width: 40px;
                height: 40px;
                transition: all 0.3s ease;
            }

            .swiper-button-next:hover,
            .swiper-button-prev:hover {
                background-color: rgba(0, 0, 0, 0.7);
            }

            .swiper-slide img {
                filter: brightness(1);
                transition: filter 0.3s ease;
            }

            .swiper-slide:hover img {
                filter: brightness(0.9);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const swiper = new Swiper('.swiper-container', {
                    // Optional parameters
                    direction: 'horizontal',
                    loop: true,
                    speed: 600,

                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },

                    // Responsive breakpoints
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 10
                        },
                        768: {
                            slidesPerView: 1,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 1,
                            spaceBetween: 30
                        }
                    }
                });
            });
        </script>
    @endpush
