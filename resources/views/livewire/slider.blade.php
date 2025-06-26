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
                        <!-- Pagination/Indicator -->
                        <div class="swiper-pagination-container">
                            <div class="swiper-pagination"></div>
                        </div>
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
                    overflow: hidden;
                }

                /* Styling untuk tombol navigasi dengan ikon */
                .swiper-button-next,
                .swiper-button-prev {
                    background-color: rgba(0, 0, 0, 0.5);
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .swiper-button-next:hover,
                .swiper-button-prev:hover {
                    background-color: rgba(0, 0, 0, 0.8);
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

                .swiper-slide {
                    border-radius: 8px;
                    position: relative;
                }

                /* Custom Pagination */
                .swiper-pagination-container {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    z-index: 9;
                    display: flex;
                    justify-content: center;
                    padding: 15px 0 5px 0;
                }

                .swiper-pagination {
                    position: relative;
                    display: flex;
                    justify-content: center;
                    gap: 8px;
                    margin: 0;
                    padding: 5px 10px;
                    background: transparent;
                    border-radius: 20px;
                }

                .swiper-pagination-bullet {
                    width: 12px;
                    height: 12px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    margin: 0 2px !important;
                    opacity: 0.7;
                }

                .swiper-pagination-bullet-active {
                    background: #fff;
                    opacity: 1;
                    transform: scale(1.2);
                    box-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
                }

                /* Navigation Buttons */
                .swiper-button-prev,
                .swiper-button-next {
                    width: 44px;
                    height: 44px;
                    background: rgba(0, 0, 0, 0.5);
                    border-radius: 50%;
                    color: white;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    z-index: 9;
                    backdrop-filter: blur(4px);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }

                .swiper-button-prev {
                    left: 20px;
                }

                .swiper-button-next {
                    right: 20px;
                }

                .swiper-button-prev:hover,
                .swiper-button-next:hover {
                    background: rgba(0, 0, 0, 0.8);
                    transform: translateY(-50%) scale(1.1);
                }

                .swiper-button-prev::after,
                .swiper-button-next::after {
                    display: none;
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

                .swiper-button-next,
                .swiper-button-prev {
                    color: #fff;
                    background: rgba(0, 0, 0, 0.5);
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    transition: all 0.3s ease;
                }

                .swiper-button-next:after,
                .swiper-button-prev:after {
                    font-size: 1.2rem;
                }

                .swiper-pagination-bullet {
                    background: #fff;
                    opacity: 0.7;
                }

                .swiper-pagination-bullet-active {
                    background: var(--primary);
                    opacity: 1;
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

                .text-truncate-2 {
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
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

                @media (max-width: 991.98px) {
                    .main-slider {
                        margin-bottom: 1.5rem;
                        height: 300px !important;
                    }

                    .swiper-slide {
                        height: 300px !important;
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
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });

                    // Initialize any news-related scripts here if needed

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
                    bannerModal.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const imageUrl = button.getAttribute('data-img-url');
                        const modalImage = bannerModal.querySelector('#modalBannerImage');
                        modalImage.src = imageUrl;
                    });
                });
            </script>
        @endpush
    @else
        <div class="swiper-slide"
            style="background-image: url('{{ asset('assets/img/hero-img.png') }}'); background-size: contain; background-position: center; background-color: #f8f9fa; height: 85vh; position: relative; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden; transform: scale(0.9);">
            <div
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.5));">
            </div>
            <div style="position: relative; z-index: 2; height: 100%; display: flex; align-items: center;">
                <div class="row" style="width: 100%; margin: 0;">
                    <div class="col-lg-8 ml-5" style="text-align: left; margin-left: 5rem;">
                        <div class="slider-content" style="color: #ffffff; padding: 0 20px; text-align: left;">
                            <h2 data-aos="fade-up"
                                style="font-size: 3rem; font-weight: 700; color: #ffffff; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                Selamat Datang di Portal Resmi</h2>
                            <h1 data-aos="fade-up"
                                style="color: #ffffff; font-size: 3.5rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                {{ $pengaturan->nama_instansi ?? 'WebOPD' }}</h1>
                            <p data-aos="fade-up" data-aos-delay="400"
                                style="font-size: 1.2rem; color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">
                                {{ $pengaturan->deskripsi_singkat ?? 'Portal resmi untuk informasi dan layanan publik.' }}
                            </p>
                            <div data-aos="fade-up" data-aos-delay="600">
                                <div>
                                    <a href="{{ route('berita.index') }}"
                                        class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                        <span>Lihat Berita</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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
</section><!-- End Hero -->

@push('styles')
    <style>
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

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: #fff;
            transform: scale(1.2);
        }

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

        padding: 0;
        margin: 0;
        margin-top: 0 !important;
        padding-top: 0 !important;
        width: 100%;
        overflow: hidden;
        position: relative;
        top: -10px;
        }

        .slider.swiper {
            width: 100%;
            height: 100%;
            margin: 0 auto;
        }

        .slider .swiper-slide {
            padding: 0;
            width: 100%;
            border-radius: 0;
        }

        .slider.swiper {
            border-radius: 0;
        }

        .swiper-button-next,
        .swiper-button-prev {
            margin: 0 20px;
        }

        .swiper-pagination {
            bottom: 0 !important;
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
            new Swiper('.main-slider', {
                speed: 600,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                slidesPerView: 1,
                pagination: {
                    el: '.swiper-pagination',
                    type: 'bullets',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }
            });
        });
    </script>
@endpush
