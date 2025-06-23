<section id="hero" class="hero">
    @if ($sliders && count($sliders) > 0)
        <div class="container-fluid">
            <div class="row gx-4">
                <!-- Main Slider (wider on large screens) -->
                <div class="col-lg-9">
                    <div class="swiper main-slider">
                        <div class="swiper-wrapper">
                            @foreach (array_slice($sliders, 0, 5) as $slider)
                                @php
                                    $slider = is_object($slider) ? (array) $slider : $slider;
                                    $imageUrl = $slider['gambar_url'] ?? asset('assets/img/hero-img.png');
                                    $title = $slider['judul'] ?? 'No Title';
                                    $url = $slider['url'] ?? '#';
                                @endphp
                                <div class="swiper-slide" style="height: 400px;">
                                    <div class="position-relative h-100 w-100">
                                        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-100 h-100"
                                            style="object-fit: cover;">
                                        <div class="position-absolute bottom-0 start-0 w-100 p-4"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                            <h3 class="text-white mb-2">
                                                <a href="{{ $url }}"
                                                    class="text-white text-decoration-none">{{ Str::limit($title, 70) }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

                <!-- Banner Slider (narrower on large screens) -->
                <div class="col-lg-3">
                    <div class="swiper banner-slider w-100">
                        <div class="swiper-wrapper">
                            @forelse($banners as $banner)
                                <div class="swiper-slide" style="height: 400px;">
                                    <a href="#" class="d-block h-100 banner-item" data-bs-toggle="modal"
                                        data-bs-target="#bannerModal" data-img-url="{{ $banner['gambar_url'] }}">
                                        <img src="{{ $banner['gambar_url'] }}" alt="{{ $banner['judul'] }}"
                                            class="w-100 h-100" style="object-fit: cover;">
                                    </a>
                                </div>
                            @empty
                                <div class="swiper-slide" style="height: 400px;">
                                    <img src="{{ asset('placeholder.jpg') }}" alt="Placeholder"
                                        style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                            @endforelse
                        </div>
                        @if (count($banners) > 1)
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next banner-button-next"></div>
                            <div class="swiper-button-prev banner-button-prev"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @push('styles')
            <style>
                .main-slider {
                    height: 400px;
                    border-radius: 0;
                    overflow: hidden;
                    /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); */
                }

                .banner-slider {
                    height: 400px;
                    border-radius: 0;
                    overflow: hidden;
                }

                .swiper-slide {
                    /* position: relative; */
                    overflow: hidden;
                }

                .banner-slider {
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                }

                .banner-slider .swiper-wrapper {
                    height: 100%;
                    width: 100%;
                }

                .banner-slider .swiper-slide {
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    position: relative;
                    overflow: hidden;
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

                /* Title overlay */
                .banner-slider .swiper-slide .banner-caption {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 8px 12px;
                    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
                    color: white;
                    font-size: 0.8rem;
                    line-height: 1.2;
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

                .banner-slider .swiper-button-next,
                .banner-slider .swiper-button-prev {
                    width: 35px;
                    height: 35px;
                    background: rgba(0, 0, 0, 0.3);
                    color: #fff;
                }

                .banner-slider .swiper-button-next:after,
                .banner-slider .swiper-button-prev:after {
                    font-size: 1rem;
                }


                .swiper-pagination-bullet {
                    background: #fff;
                    opacity: 0.7;
                }

                .swiper-pagination-bullet-active {
                    background: var(--primary);
                    opacity: 1;
                }

                @media (max-width: 991.98px) {
                    .main-slider {
                        margin-bottom: 0;
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
                    new Swiper('.main-slider', {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
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
    </div>
</section><!-- End Hero -->

@push('styles')
    <style>
        /* Hide slider pagination */
        .swiper-pagination {
            display: none !important;
        }
        
        #hero.hero {
            width: 100%;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
            padding-bottom: 5px; /* Further reduced from 20px */
            margin-bottom: -10px; /* Negative margin to pull content up */
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
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .post-tag .badge {
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .post-tag .ms-3 {
            font-size: 0.9rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
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
            background: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            transition: all 0.3s ease;
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
            bottom: 20px !important;
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
            new Swiper('.slider.swiper', {
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
