<section id="hero" class="hero p-0">
    @if ($sliders && count($sliders) > 0)
        <div class="container-fluid p-0 m-0 w-100">
            <div class="row g-0 w-100 m-0">
                <!-- Main Slider (full width) -->
                <div class="col-12 p-0">
                    <div class="swiper main-slider w-100">
                        <div class="swiper-wrapper">
                            @foreach (array_slice($sliders, 0, 5) as $slider)
                                @php
                                    $slider = is_object($slider) ? (array) $slider : $slider;
                                    $imageUrl = $slider['gambar_url'] ?? asset('assets/img/hero-img.png');
                                    $title = $slider['judul'] ?? 'No Title';
                                    $url = $slider['url'] ?? '#';
                                @endphp
                                <div class="swiper-slide" style="height: 80vh; min-height: 500px; max-height: 800px;">
                                    <div class="position-relative h-100 w-100">
                                        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-100 h-100"
                                            style="object-fit: cover; object-position: center; width: 100%; height: 100%;">
                                        <!-- Latar belakang gradient -->
                                        <div class="position-absolute bottom-0 start-0 w-100 p-4"
                                            style="background: linear-gradient(to top, rgba(46, 87, 211, 0.8), transparent); z-index: 10; height: 150px;">
                                        </div>
                                        
                                        <!-- Judul dan tag dengan efek fade -->
                                        <div class="position-absolute bottom-0 start-0 w-100 p-4 slide-text"
                                            style="z-index: 11;">
                                            <h3 class="text-white mb-2 fw-bold" 
                                                style="opacity: 0; animation: slideInFromTop 0.8s ease-out 0.5s forwards;">
                                                <a href="{{ $url }}"
                                                    class="text-white text-decoration-none fs-4"
                                                    style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">{{ Str::limit($title, 70) }}</a>
                                            </h3>
                                            @if (isset($slider['is_post']) && $slider['is_post'] && isset($slider['tags']) && count($slider['tags']) > 0)
                                                <div class="post-tags d-flex flex-wrap gap-2 mb-3">
                                                    @foreach ($slider['tags'] as $tag)
                                                        <a href="{{ route('post.tag', ['tag' => Str::slug($tag)]) }}"
                                                            class="post-tag bg-primary text-decoration-none text-white">{{ $tag }}</a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Navigation Buttons -->
                        <div class="swiper-button-next"><i class="bi bi-chevron-right"></i></div>
                        <div class="swiper-button-prev"><i class="bi bi-chevron-left"></i></div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>


            </div>
        </div>

        @push('styles')
            <style>
                .main-slider {
                    height: 80vh;
                    min-height: 500px;
                    max-height: 800px;
                    width: 100%;
                    overflow: visible; /* Mengubah dari hidden ke visible agar pagination terlihat */
                    position: relative; /* Memastikan posisi relatif untuk pagination absolut */
                    margin-bottom: 60px; /* Memberikan ruang untuk pagination di luar frame */
                }

                /* Styling untuk tombol navigasi dengan ikon */
                .swiper-button-next,
                .swiper-button-prev {
                    background-color: rgba(0, 0, 0, 0.5);
                    width: 44px;
                    height: 44px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    z-index: 9;
                    backdrop-filter: blur(4px);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    color: white;
                    transition: all 0.3s ease;
                    opacity: 0.8;
                }

                .swiper-button-next:hover,
                .swiper-button-prev:hover {
                    background: rgba(0, 0, 0, 0.8);
                    transform: translateY(-50%) scale(1.1);
                    opacity: 1;
                }

                .swiper-button-next::after,
                .swiper-button-prev::after {
                    display: none;
                    /* Menyembunyikan tanda panah default */
                }

                .swiper-button-next i,
                .swiper-button-prev i {
                    font-size: 1.5rem;
                    color: white;
                }

                .swiper-button-prev {
                    left: 20px;
                }

                .swiper-button-next {
                    right: 20px;
                }

                .swiper-slide {
                    border-radius: 8px;
                    position: relative;
                    background-size: cover;
                    background-position: center;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    transform: translate3d(0, 0, 0);
                    -webkit-transform: translate3d(0, 0, 0);
                    backface-visibility: hidden;
                    -webkit-backface-visibility: hidden;
                    -webkit-transform-style: preserve-3d;
                    transform-style: preserve-3d;
                }



                .spin {
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }

                .opacity-50 {
                    opacity: 0.5;
                    transition: opacity 0.3s ease;
                }

                .text-truncate-2 {
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .news-list {
                    height: 100%;
                    overflow-y: auto;
                }

                .hover-bg {
                    transition: background-color 0.2s ease;
                }

                .hover-bg:hover {
                    background-color: #f8f9fa;
                }

                /* Custom scrollbar */
                .card-body::-webkit-scrollbar {
                    width: 4px;
                }

                .card-body::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }

                .card-body::-webkit-scrollbar-thumb {
                    background: #888;
                    border-radius: 10px;
                }

                .card-body::-webkit-scrollbar-thumb:hover {
                    background: #555;
                }

                /* Animation for slider text */
                @keyframes slideInFromTop {
                    from {
                        opacity: 0;
                        transform: translateY(-50px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                /* Efek fade untuk slide */
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                    }
                    to {
                        opacity: 1;
                    }
                }

                .swiper-slide-active .slide-text {
                    animation: fadeIn 1s ease forwards;
                }

                /* Styling untuk tag post di slider */
                .post-tag {
                    font-size: 0.75rem;
                    font-weight: 500;
                    padding: 0.25rem 0.5rem;
                    border-radius: 4px;
                    margin-right: 5px;
                    margin-bottom: 5px;
                    display: inline-block;
                    text-shadow: none;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                    transition: all 0.3s ease;
                    color: white;
                }

                .post-tag:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                    background-color: #0d6efd !important;
                    color: white;
                    opacity: 0.9;
                }

                .post-tags {
                    margin-top: -5px;
                    margin-bottom: 10px;
                }

                #hero.hero {
                    width: 100%;
                    overflow: hidden;
                    -webkit-font-smoothing: antialiased;
                    padding-bottom: 5px;
                    margin-bottom: -10px;
                    -moz-osx-font-smoothing: grayscale;
                }

                @media (max-width: 991.98px) {
                    .main-slider {
                        margin-bottom: 1.5rem;
                        height: 300px !important;
                    }

                    .swiper-slide {
                        height: 300px !important;
                    }
                    
                    .swiper-pagination-bullet {
                        width: 28px !important;
                        height: 28px !important;
                        font-size: 12px !important;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        opacity: 1 !important;
                        visibility: visible !important;
                        margin: 0 5px !important;
                        border: 2px solid rgba(0, 0, 0, 0.3) !important;
                    }
                }

                @media (max-width: 768px) {
                    .slider-content {
                        margin-left: 2rem;
                        margin-right: 2rem;
                    }

                    .slider-content h2 {
                        font-size: 2rem !important;
                    }

                    .slider-content p {
                        font-size: 1rem !important;
                    }

                    .post-tag {
                        flex-direction: column;
                        align-items: flex-start;
                    }

                    .swiper-pagination-bullet {
                        width: 30px !important;
                        height: 30px !important;
                        font-size: 14px !important;
                        margin: 0 5px !important;
                        border: 2px solid rgba(0, 0, 0, 0.5) !important;
                    }
                    
                    .main-slider {
                        margin-bottom: 50px; /* Memberikan ruang untuk pagination di luar frame pada layar kecil */
                    }

                    .post-tag .ms-3 {
                        margin-left: 0 !important;
                        margin-top: 0.5rem;
                    }
                }
            </style>
        @endpush

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Main Slider
                    const mainSlider = new Swiper('.main-slider', {
                        loop: true,
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                            type: 'bullets',
                            bulletClass: 'swiper-pagination-bullet',
                            bulletActiveClass: 'swiper-pagination-bullet-active',
                            renderBullet: function (index, className) {
                                return '<span class="' + className + '">' + (index + 1) + '</span>';
                            },
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        speed: 800,
                        on: {
                            slideChangeTransitionStart: function () {
                                const activeSlide = this.slides[this.activeIndex];
                                const slideText = activeSlide.querySelector('.slide-text');
                                if (slideText) {
                                    slideText.style.opacity = '0';
                                    setTimeout(() => {
                                        slideText.style.opacity = '1';
                                    }, 300);
                                }
                            }
                        }
                    });

                    // Banner Slider
                    const bannerSwiper = new Swiper('.banner-slider', {
                        loop: true,
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        autoplay: {
                            delay: 3000,
                            disableOnInteraction: false,
                        },
                        speed: 800,
                        navigation: {
                            nextEl: '.banner-button-next',
                            prevEl: '.banner-button-prev',
                        },
                    });

                    const bannerModal = document.getElementById('bannerModal');
                    if (bannerModal) {
                        bannerModal.addEventListener('show.bs.modal', function(event) {
                            const button = event.relatedTarget;
                            const imageUrl = button.getAttribute('data-img-url');
                            const modalImage = bannerModal.querySelector('#modalBannerImage');
                            modalImage.src = imageUrl;
                        });
                    }
                });
            </script>
        @endpush
    @else
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh; background-color: #f8f9fa;">
            <div class="text-center">
                <i class="bi bi-image text-4xl mb-4" style="font-size: 3rem; color: #6c757d;"></i>
                <p class="text-lg text-muted">Tidak ada slider tersedia</p>
            </div>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalBannerImage" src="" class="img-fluid" alt="Banner Image">
                </div>
            </div>
        </div>
    </div>
</section><!-- End Hero -->

@push('styles')
    <style>
        /* Swiper Pagination Custom Centered and Transparent */
        .swiper-pagination {
            position: absolute;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            bottom: 30px;
            width: fit-content;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 8px 16px;
            z-index: 20;
        }
        .swiper-pagination-bullet {
            background: rgba(255,255,255,0.7);
            color: #222;
            border: 1px solid #888;
            width: 32px;
            height: 32px;
            margin: 0 4px;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: all 0.2s;
        }
        .swiper-pagination-bullet-active {
            background: #2e57d3;
            color: #fff;
            border: 2px solid #fff;
            transform: scale(1.15);
        }

        /* Animation for slider text */
        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Slider pagination styling */
        .swiper-pagination {
            display: flex !important;
        }

        #hero.hero {
            width: 100%;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
            padding-bottom: 5px;
            /* Further reduced from 20px */
            margin-bottom: -10px;
            /* Negative margin to pull content up */
            -moz-osx-font-smoothing: grayscale;
        }

        .swiper-slide {
            transform: translate3d(0, 0, 0);
            -webkit-transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .slider-container {
            width: 100%;
            height: 85vh;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5));
        }

        .slider-content {
            position: relative;
            z-index: 2;
            color: #ffffff;
            padding: 0 15px;
            text-align: left;
            margin-left: 4rem;
            max-width: 800px;
        }

        /* Styling untuk tag post di slider */
        .post-tag {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
            text-shadow: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            color: white;
        }

        .post-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            background-color: #0d6efd !important;
            color: white;
            opacity: 0.9;
        }

        .post-tags {
            margin-top: -5px;
            margin-bottom: 10px;
        }

        /* Pagination styling sudah didefinisikan di bagian atas */

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            width: 50px;
            height: 50px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 10;
            opacity: 0.8;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(0, 0, 0, 0.6);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .slider-content {
                margin-left: 2rem;
                margin-right: 2rem;
            }

            .slider-content h2 {
                font-size: 2rem !important;
            }

            .slider-content p {
                font-size: 1rem !important;
            }

            .post-tag {
                flex-direction: column;
                align-items: flex-start;
            }



            .post-tag .ms-3 {
                margin-left: 0 !important;
                margin-top: 0.5rem;
            }
        }

        /* Slider configuration */
        .slider.swiper {
            width: 100%;
            height: 100%;
            margin: 0 auto;
            position: relative;
            overflow: visible;
            border-radius: 0;
        }

        .slider .swiper-slide {
            padding: 0;
            width: 100%;
            border-radius: 0;
        }

        .swiper-button-next,
        .swiper-button-prev {
            margin: 0 20px;
        }

        /* Ensuring pagination visibility */
        .swiper-container, .swiper {
            overflow: visible !important;
            position: relative !important;
        }
        
        /* Preventing container from clipping pagination */
        .container-fluid, .row, .col-12 {
            overflow: visible !important;
        }

        .slider-content {
            color: #ffffff !important;
            text-align: left !important;
        }

        .slider-content h1,
        .slider-content h2 {
            color: #ffffff !important;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5), 2px 2px 4px rgba(0, 0, 0, 0.8);
            font-weight: 700;
            letter-spacing: 1px;
            text-align: left !important;
        }

        .slider-content p {
            color: #ffffff !important;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.4), 1px 1px 3px rgba(0, 0, 0, 0.8);
            font-size: 1.2rem;
            letter-spacing: 0.5px;
            line-height: 1.6;
            text-align: left !important;
        }

        .animate__animated.animate__fadeInRight {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translate3d(100%, 0, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .animate__fadeInRight {
            animation-name: fadeInRight;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set Carbon locale to Indonesian
            window.Carbon && window.Carbon.setLocale('id');
            // Inisialisasi Swiper sudah dilakukan di bagian atas, tidak perlu diinisialisasi lagi di sini
        });
    </script>
@endpush
