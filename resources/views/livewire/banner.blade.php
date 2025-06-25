<div>
    <div class="w-full overflow-hidden rounded-lg shadow-lg mb-6">
        <div class="swiper banner-slider">
            <div class="swiper-wrapper">
                @forelse ($banners as $banner)
                    <div class="swiper-slide">
                        <div class="relative w-full h-48 md:h-64 overflow-hidden">
                            <a href="{{ $banner->gambar_url }}" class="glightbox group relative block">
                                <img src="{{ $banner->gambar_url }}" alt="{{ $banner->judul }}"
                                    class="w-full h-full object-cover">
                                @if ($banner->judul || $banner->keterangan)
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                                        @if ($banner->judul)
                                            <h3 class="text-white text-sm font-bold">{{ $banner->judul }}</h3>
                                        @endif
                                        @if ($banner->keterangan)
                                            <p class="text-white/90 text-xs line-clamp-1">{{ $banner->keterangan }}</p>
                                        @endif
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="relative w-full h-48 md:h-64 bg-gray-100 flex items-center justify-center">
                            <div class="text-center p-4">
                                <i class="bi bi-image text-4xl text-gray-400"></i>
                                <p class="text-gray-500 text-sm mt-2">Tidak ada banner</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.banner-slider', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });

            // Inisialisasi GLightbox untuk banner
            const bannerLightbox = GLightbox({
                selector: '.banner-slider .glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: false
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Banner Slider Styles */
        .banner-portrait-container {
            position: relative;
            width: 100%;
            max-width: 300px;
            /* Adjust based on your preference */
            height: auto;
            min-height: 400px;
            /* Adjust based on your content */
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
            margin: 0 auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .banner-portrait-container:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .banner-image-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 400px;
            /* Match container min-height */
        }

        .banner-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Changed from cover to contain */
            object-position: center;
            transition: transform 0.5s ease;
            display: block;
        }

        .banner-portrait-container:hover .banner-image-wrapper img {
            transform: scale(1.05);
        }

        .banner-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 12px 15px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            color: white;
            z-index: 2;
        }

        .banner-title {
            font-size: 0.85rem;
            line-height: 1.3;
            font-weight: 500;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Swiper Navigation */
        .swiper.banner-slider {
            border-radius: 8px;
            overflow: visible;
            padding: 10px 0;
            /* Add some padding to prevent shadow clipping */
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            background: rgba(0, 0, 0, 0.5);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper:hover .swiper-button-next,
        .swiper:hover .swiper-button-prev {
            opacity: 1;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1rem;
            font-weight: bold;
        }

        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: #fff;
            width: 20px;
            border-radius: 4px;
        }

        .banner-slider {
            min-height: 450px;
            /* Increased to accommodate content */
            border-radius: 8px;
            overflow: visible;
            box-shadow: none;
            width: 100%;
            max-width: 320px;
            /* Match container width */
            margin: 0 auto;
            padding: 10px 0;
        }

        .banner-slider .swiper-wrapper {
            height: auto;
            align-items: stretch;
            padding: 10px 0 20px;
        }

        .banner-slider .swiper-slide {
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-sizing: border-box;
            position: relative;
            transition: transform 0.3s ease;
            box-shadow: none;
        }

        .banner-slider .swiper-slide:last-child {
            margin-bottom: 0;
        }

        .banner-slider .swiper-slide>a {
            display: block;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .banner-slider .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: 0;
            padding: 0;
        }

        .banner-slider .swiper-button-next,
        .banner-slider .swiper-button-prev {
            width: 30px;
            height: 30px;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            border-radius: 50%;
        }

        .banner-slider .swiper-button-next:after,
        .banner-slider .swiper-button-prev:after {
            font-size: 0.9rem;
        }

        .banner-slider .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.7;
        }

        .banner-slider .swiper-pagination-bullet-active {
            background: var(--primary);
            opacity: 1;
        }

        /* Card Styles */
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
            border-color: rgba(13, 110, 253, 0.2);
        }

        .card-img-top {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-title a {
            transition: color 0.3s ease;
        }

        .card:hover .card-title a {
            color: #0d6efd !important;
        }

        /* Informasi Item Hover Effect */
        .informasi-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0.5rem;
            border: 1px solid transparent;
        }

        .informasi-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            border-color: #93c5fd;
            background-color: #f8fafc !important;
        }

        .informasi-item .flex-shrink-0 div {
            transition: all 0.3s ease;
        }

        .informasi-item:hover .flex-shrink-0 div {
            transform: scale(1.1);
            background-color: #3b82f6 !important;
            color: white;
        }

        .informasi-item .bi-chevron-right {
            transition: all 0.3s ease;
        }

        .informasi-item:hover .bi-chevron-right {
            transform: translateX(3px);
            color: #3b82f6 !important;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.35rem 0.65rem;
            border-radius: 0.375rem;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
        }

        .card {
            cursor: pointer;
        }

        .card-title {
            transition: color 0.3s ease;
        }

        .card:hover .card-title {
            color: #0d6efd !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // Initialize banner slider with smooth transitions
        function initBannerSlider() {
            // Only initialize if there are banners
            const bannerSlider = document.querySelector('.banner-slider');
            if (!bannerSlider) return;

            // Initialize Swiper with custom pagination
            const swiper = new Swiper(bannerSlider, {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    bulletClass: 'swiper-pagination-bullet',
                    bulletActiveClass: 'swiper-pagination-bullet-active',
                    renderBullet: function(index, className) {
                        return `<span class="${className}"><i class="bi bi-circle-fill"></i></span>`;
                    },
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'slide',
                speed: 800,
                grabCursor: true,
                spaceBetween: 0,
                centeredSlides: true,
                slidesPerView: 1,
                on: {
                    init: function() {
                        // Add active class to first slide
                        const slides = document.querySelectorAll('.banner-slider .swiper-slide');
                        if (slides.length > 0) {
                            slides[0].classList.add('swiper-slide-active');
                        }
                    },
                    slideChange: function() {
                        const bullets = bannerSlider.querySelectorAll('.swiper-pagination-bullet');
                        const activeIndex = this.realIndex % bullets.length;

                        bullets.forEach((bullet, index) => {
                            if (index === activeIndex) {
                                bullet.classList.add('swiper-pagination-bullet-active');
                                bullet.setAttribute('aria-current', 'true');
                            } else {
                                bullet.classList.remove('swiper-pagination-bullet-active');
                                bullet.removeAttribute('aria-current');
                            }
                        });
                    }
                }
            });

            // Get the number of banners
            const bannerCount = bannerSlider.querySelectorAll('.swiper-slide').length;

            // Enable autoplay if there are multiple banners
            if (bannerCount > 1) {
                window.bannerSwiper.params.autoplay = {
                    delay: 5000,
                    disableOnInteraction: false,
                    waitForTransition: true,
                    pauseOnMouseEnter: true
                };
            }

            // Add keyboard control
            window.bannerSwiper.keyboard = {
                enabled: true,
                onlyInViewport: true
            };

            // Add mousewheel control
            window.bannerSwiper.mousewheel = {
                forceToAxis: true
            };

            // Enable lazy loading
            window.bannerSwiper.lazy = {
                loadPrevNext: true,
                loadPrevNextAmount: 2
            };

            // Additional settings
            window.bannerSwiper.autoHeight = true;
            window.bannerSwiper.watchSlidesProgress = true;
            window.bannerSwiper.preloadImages = false;
            window.bannerSwiper.resizeObserver = true;
            window.bannerSwiper.parallax = true;

            // Pause autoplay on hover
            const slider = bannerSlider;
            if (slider) {
                slider.addEventListener('mouseenter', () => {
                    if (window.bannerSwiper.autoplay && window.bannerSwiper.autoplay.running) {
                        window.bannerSwiper.autoplay.stop();
                    }
                });

                slider.addEventListener('mouseleave', () => {
                    if (window.bannerSwiper.autoplay && !window.bannerSwiper.autoplay.running && bannerCount > 1) {
                        window.bannerSwiper.autoplay.start();
                    }
                });
            }
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', initBannerSlider);

        // Initialize on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initBannerSlider);
        } else {
            initBannerSlider();
        }

        // Reinitialize when Livewire navigates
        document.addEventListener('livewire:navigated', function() {
            // Small delay to ensure DOM is ready
            setTimeout(initBannerSlider, 100);
        });

        // Re-initialize when Livewire updates the DOM
        document.addEventListener('livewire:initialized', initBannerSlider);
        document.addEventListener('livewire:update', function() {
            setTimeout(initBannerSlider, 100);
        });

        // Banner modal functionality
        const bannerModal = document.getElementById('bannerModal');
        if (bannerModal) {
            const bannerModalImg = document.getElementById('bannerModalImg');

            // Handle banner clicks to show modal with full image
            document.querySelectorAll('.banner-portrait-container a').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const img = this.querySelector('img');
                    if (img) {
                        bannerModalImg.src = img.src;
                        bannerModalImg.alt = img.alt || 'Banner';
                        const modal = new bootstrap.Modal(bannerModal);
                        modal.show();
                    }
                });
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scrolling for news container
            initHorizontalScroll('.scroll-container', '.scroll-left', '.scroll-right');

            // Initialize scrolling for video container
            initHorizontalScroll('.video-scroll-container');

            // Initialize video modals
            initVideoModals();

            function initHorizontalScroll(containerSelector, prevBtnSelector = null, nextBtnSelector = null) {
                const container = document.querySelector(containerSelector);
                if (!container) return;

                const scrollAmount = 300; // Adjust this value to control scroll distance
                let prevBtn, nextBtn;

                if (prevBtnSelector && nextBtnSelector) {
                    prevBtn = document.querySelector(prevBtnSelector);
                    nextBtn = document.querySelector(nextBtnSelector);
                }


                if (prevBtn && nextBtn) {
                    // Navigation with buttons
                    prevBtn.addEventListener('click', function() {
                        container.scrollBy({
                            left: -scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    nextBtn.addEventListener('click', function() {
                        container.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    // Hide/show buttons based on scroll position
                    const updateButtonVisibility = () => {
                        const {
                            scrollLeft,
                            scrollWidth,
                            clientWidth
                        } = container;
                        prevBtn.style.visibility = scrollLeft > 0 ? 'visible' : 'hidden';
                        nextBtn.style.visibility = scrollLeft < (scrollWidth - clientWidth - 1) ? 'visible' :
                            'hidden';
                    };

                    container.addEventListener('scroll', updateButtonVisibility);
                    window.addEventListener('resize', updateButtonVisibility);
                    updateButtonVisibility(); // Initial check
                } else {
                    // Touch/swipe support for mobile
                    let isDown = false;
                    let startX;
                    let scrollLeft;

                    container.addEventListener('mousedown', (e) => {
                        isDown = true;
                        startX = e.pageX - container.offsetLeft;
                        scrollLeft = container.scrollLeft;
                        container.style.cursor = 'grabbing';
                        container.style.userSelect = 'none';
                    });

                    container.addEventListener('mouseleave', () => {
                        isDown = false;
                        container.style.cursor = 'grab';
                    });

                    container.addEventListener('mouseup', () => {
                        isDown = false;
                        container.style.cursor = 'grab';
                    });

                    container.addEventListener('mousemove', (e) => {
                        if (!isDown) return;
                        e.preventDefault();
                        const x = e.pageX - container.offsetLeft;
                        const walk = (x - startX) * 2; // Scroll-fast
                        container.scrollLeft = scrollLeft - walk;
                    });
                }
            }


            function initVideoModals() {
                // This function can be expanded to handle video modal initialization
                // when a video thumbnail is clicked
                const videoPlayButtons = document.querySelectorAll('.video-play-button');

                videoPlayButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const videoUrl = this.getAttribute('data-video');
                        // Here you can implement a modal to play the video
                        // For example, using Bootstrap's modal or another lightbox solution
                        console.log('Play video:', videoUrl);
                    });
                });
            }
        });
    </script>
@endpush
