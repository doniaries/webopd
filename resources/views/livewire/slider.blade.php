<section id="hero" class="hero">
    @if ($sliders && count($sliders) > 0)
        <div class="swiper slider-container" id="mainSlider">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    @php
                        // Convert to array if it's an object with public properties
                        $slider = is_object($slider) ? (array) $slider : $slider;
                        $imageUrl = $slider['gambar_url'] ?? asset('assets/img/hero-img.png');
                        $title = $slider['judul'] ?? 'No Title';
                        $description = $slider['deskripsi'] ?? '';
                        $url = $slider['url'] ?? '#';
                        $author = $slider['author_name'] ?? 'Admin';
                        $date = isset($slider['published_at']) ? \Carbon\Carbon::parse($slider['published_at'])->translatedFormat('d F Y') : '';
                        $tags = $slider['tags'] ?? [];
                    @endphp
                    
                    <div class="swiper-slide"
                         style="background-image: url('{{ $imageUrl }}'); background-size: cover; background-position: center;">
                        <div class="slide-overlay"></div>
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-lg-8 col-md-10 mx-auto">
                                    <div class="slider-content text-white p-4" data-aos="fade-up">
                                        @if(!empty($tags))
                                            <div class="mb-2">
                                                @foreach(array_slice($tags, 0, 2) as $tag)
                                                    <span class="badge bg-primary me-1">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <h1 class="mb-3">
                                            <a href="{{ $url }}" class="text-white text-decoration-none">
                                                {{ $title }}
                                            </a>
                                        </h1>
                                        
                                        <p class="mb-4">{{ $description }}</p>
                                        
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center me-4">
                                                <i class="bi bi-person me-2"></i>
                                                <span>{{ $author }}</span>
                                            </div>
                                            @if($date)
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-calendar3 me-2"></i>
                                                    <span>{{ $date }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="mt-4">
                                            <a href="{{ $url }}" class="btn btn-primary">
                                                Baca Selengkapnya
                                                <i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const swiper = new Swiper('#mainSlider', {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        speed: 1000,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                });
            </script>
        @endpush
    @else
        <div class="swiper-slide"
            style="background-image: url('{{ asset('assets/img/hero-img.png') }}'); background-size: cover; background-position: center; height: 85vh; position: relative; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
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
</section><!-- End Hero -->

@push('styles')
    <style>
        #hero.hero {
            width: 100%;
            overflow: hidden;
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
