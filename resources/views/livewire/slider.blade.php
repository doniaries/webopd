<div class="relative w-full" x-data="{
    initSwiper() {
        new Swiper(this.$refs.swiperContainer, {
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
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 800,
        });
    }
}" x-init="initSwiper()">
    @if ($sliders && count($sliders) > 0)
        <div class="swiper main-slider w-full" x-ref="swiperContainer">
            <div class="swiper-wrapper">
                @foreach (array_slice($sliders, 0, 5) as $slider)
                    @php
                        $slider = is_object($slider) ? (array) $slider : $slider;
                        $imageUrl = $slider['gambar_url'] ?? asset('assets/img/hero-img.png');
                        $title = $slider['judul'] ?? 'No Title';
                        $url = $slider['url'] ?? '#';
                    @endphp
                    <div class="swiper-slide relative" style="height: 80vh; min-height: 500px; max-height: 800px;">
                        <div class="relative w-full h-full">
                            <!-- Background Image -->
                            <img src="{{ $imageUrl }}" alt=""
                                class="w-full h-full object-cover object-center">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black/40 z-10"></div>

                            <!-- Blue Gradient Overlay -->
                            <div class="absolute bottom-0 left-0 z-10 h-full w-2/3 md:w-1/2"
                                style="background: linear-gradient(90deg, rgba(0, 69, 142, 0.8) 0%, rgba(0, 69, 142, 0.4) 70%, transparent 100%);">
                            </div>

                            <!-- Content Container -->
                            <div
                                class="absolute bottom-0 left-0 w-full z-20 px-8 sm:px-12 md:px-16 lg:px-20 xl:px-24 pb-16">
                                <div class="max-w-5xl pr-8 lg:pr-20">
                                    <!-- Tags -->
                                    @if (isset($slider['tags']) && count($slider['tags']) > 0)
                                        <div class="flex flex-wrap gap-2 mb-3" data-aos="fade-up"
                                            data-aos-duration="100" data-aos-delay="0" style="margin-left: 3.5rem;">
                                            @foreach ($slider['tags'] as $tag)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-blue-800 shadow-sm">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <h2 class="text-white fw-bold text-start"
                                        style="opacity: 0; animation: slideInFromTop 0.8s ease-out 0.5s forwards; max-width: 800px; margin: 2rem 0 1rem 3rem; padding-top: 0.2rem;">
                                        <a href="{{ $url }}" class="text-white text-decoration-none"
                                            style="
            display: block;
            font-size: 2.5rem;
            line-height: 1.4;
            white-space: normal;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.9);
            max-width: 100%;
            word-break: break-word;
        ">
                                            {{ $title }}
                                        </a>
                                    </h2>


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="swiper-button-next text-white"></div>
            <div class="swiper-button-prev text-white"></div>
            <div class="swiper-pagination"></div>
        </div>
    @else
        <div class="bg-gray-100 h-96 flex items-center justify-center">
            <p class="text-gray-500">Tidak ada slider yang tersedia</p>
        </div>
    @endif
</div>

@push('styles')
    <style>
        @keyframes slideInFromTop {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 3rem;
            height: 3rem;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 9999px;
            transition: all 0.3s;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.25rem;
            color: white;
        }

        .swiper-pagination-bullet {
            width: 0.75rem;
            height: 0.75rem;
            background-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
            margin: 0 0.25rem;
        }

        .swiper-pagination-bullet-active {
            background-color: white;
            transform: scale(1.25);
        }

        .swiper-slide {
            height: 60vh;
            max-height: 600px;
        }

        @media (max-width: 640px) {
            .swiper-slide {
                height: 50vh;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
