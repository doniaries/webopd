<div>
    <!-- Banner Section dengan Tailwind CSS -->
    <div class="w-full overflow-hidden rounded-lg shadow-lg mb-8">
        <!-- Swiper Container -->
        <div class="swiper-container banner-slider">
            <div class="swiper-wrapper">
                <!-- Banner Items dari komponen -->
                @forelse ($banners as $banner)
                    <div class="swiper-slide">
                        <div class="relative w-full h-64 md:h-80 lg:h-96 overflow-hidden">
                            <!-- Banner Image dengan Link untuk Modal -->
                                <a href="{{ $banner->gambar_url }}" class="glightbox group relative block" data-gallery="banner-gallery" data-title="{{ $banner->judul }}" data-description="{{ $banner->keterangan }}">
                                    <img src="{{ $banner->gambar_url }}" alt="{{ $banner->judul }}" 
                                         class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-105">
                                    
                                    <!-- Ikon Zoom -->
                                    <div class="absolute top-4 right-4 bg-white/80 p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>
                                </a>
                                
                                <!-- Banner Overlay -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 md:p-6">
                                    <h3 class="text-white text-lg md:text-xl font-bold mb-2">{{ $banner->judul }}</h3>
                                    @if ($banner->keterangan)
                                        <p class="text-white/90 text-sm md:text-base line-clamp-2">{{ $banner->keterangan }}</p>
                                    @endif
                                </div>
                        </div>
                    </div>
                @empty
                        <div class="swiper-slide">
                            <div class="relative w-full h-64 md:h-80 lg:h-96 overflow-hidden bg-gray-200 flex items-center justify-center">
                                <div class="text-center p-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <h3 class="text-gray-700 text-lg md:text-xl font-bold mb-2">Tidak Ada Banner</h3>
                                    <p class="text-gray-600 text-sm md:text-base">Belum ada banner informasi yang tersedia saat ini.</p>
                                </div>
                            </div>
                        </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation Buttons (Dalam Container) -->
            <div class="swiper-button-next text-white bg-black/40 hover:bg-black/60 rounded-full w-10 h-10 flex items-center justify-center right-4 transition-colors duration-300 after:text-lg after:font-bold">
            </div>
            <div class="swiper-button-prev text-white bg-black/40 hover:bg-black/60 rounded-full w-10 h-10 flex items-center justify-center left-4 transition-colors duration-300 after:text-lg after:font-bold">
            </div>
        </div>
    </div>
</div>

<!-- Swiper JS Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hanya inisialisasi Swiper jika ada slide
        const swiperContainer = document.querySelector('.banner-slider');
        const slidesCount = swiperContainer?.querySelectorAll('.swiper-slide')?.length || 0;

        if (slidesCount > 0) {
            const bannerSwiper = new Swiper('.banner-slider', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: slidesCount > 1, // Hanya aktifkan loop jika ada lebih dari 1 slide
                autoplay: slidesCount > 1 ? {
                    delay: 5000,
                    disableOnInteraction: false,
                } : false, // Hanya aktifkan autoplay jika ada lebih dari 1 slide
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade', // Efek transisi slide
                fadeEffect: {
                    crossFade: true
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 1,
                    },
                    1024: {
                        slidesPerView: 1,
                    },
                },
            });

            // Tambahkan event listener untuk hover pause
            swiperContainer.addEventListener('mouseenter', function() {
                if (bannerSwiper.autoplay.running) {
                    bannerSwiper.autoplay.stop();
                }
            });

            swiperContainer.addEventListener('mouseleave', function() {
                if (slidesCount > 1) {
                    bannerSwiper.autoplay.start();
                }
            });

            // Inisialisasi GLightbox untuk banner
            const bannerLightbox = GLightbox({
                selector: '.banner-slider .glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: false,
                onOpen: () => {
                    // Pause autoplay saat modal terbuka
                    if (bannerSwiper.autoplay.running) {
                        bannerSwiper.autoplay.stop();
                    }
                },
                onClose: () => {
                    // Mulai autoplay lagi saat modal ditutup
                    if (slidesCount > 1) {
                        bannerSwiper.autoplay.start();
                    }
                }
            });
        } else {
            // Sembunyikan navigasi dan pagination jika tidak ada slide
            const pagination = document.querySelector('.banner-slider .swiper-pagination');
            const nextButton = document.querySelector('.banner-slider .swiper-button-next');
            const prevButton = document.querySelector('.banner-slider .swiper-button-prev');

            if (pagination) pagination.style.display = 'none';
            if (nextButton) nextButton.style.display = 'none';
            if (prevButton) prevButton.style.display = 'none';
        }
    });
</script>
</div>
