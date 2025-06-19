<section id="hero" class="hero">
    @if ($sliders && count($sliders) > 0)
        <div class="swiper slider-container" id="mainSlider">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide"
                        style="background-image: url('{{ $slider->gambar_url ?? asset('assets/img/hero-img.png') }}');">
                        <div class="slide-overlay"></div>
                        <div
                            style="position: relative; z-index: 2; height: 100%; display: flex; align-items: center; width: 100%;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="slider-content"
                                            style="color: #ffffff; padding: 0 15px; text-align: left; margin-left: 4rem;">
                                        <h2 data-aos="fade-up"
                                            style="font-size: 3rem; font-weight: 700; color: #ffffff; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                            {{ $slider->judul }}</h2>
                                        <p data-aos="fade-up" data-aos-delay="400"
                                            style="font-size: 1.2rem; color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.8); margin-bottom: 1.5rem;">
                                            {{ $slider->deskripsi }}
                                        </p>
                                        @if(isset($slider->url) && !empty($slider->url))
                                            <div data-aos="fade-up" data-aos-delay="500">
                                                <a href="{{ $slider->url }}" 
                                                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                    Selengkapnya
                                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.5));
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
