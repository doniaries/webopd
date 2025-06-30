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
        <div class="swiper" x-ref="swiperContainer">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide relative">
                        <!-- Background Image -->
                        <div class="absolute inset-0 bg-cover bg-center"
                            style="background-image: url('{{ $slider->gambar_url ?? asset('images/placeholder.jpg') }}');">
                            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        </div>

                        <!-- Content -->
                        <div class="swiper-slide h-[80vh] min-h-[500px] max-h-[800px]">
                            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                                <div class="max-w-2xl bg-black bg-opacity-40 backdrop-blur-sm p-8 rounded-lg shadow-xl">
                                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight"
                                        data-aos="fade-up" data-aos-duration="600" data-aos-easing="ease-out-cubic">
                                        {{ $slider->judul }}
                                    </h2>

                                    <!-- Tags -->
                                    @if(isset($slider->tags) && count($slider->tags) > 0)
                                        <div class="flex flex-wrap gap-2 mb-3" data-aos="fade-up" data-aos-delay="50">
                                            @foreach($slider->tags as $tag)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (!empty($slider->deskripsi))
                                        <p class="text-gray-200 text-lg mb-6" data-aos="fade-up" data-aos-delay="100"
                                            data-aos-duration="500">
                                            {{ $slider->deskripsi }}
                                        </p>
                                    @endif

                                    @if (!empty($slider->url))
                                        <div class="mt-6" data-aos="fade-up" data-aos-delay="200">
                                            <a href="{{ $slider->url }}"
                                                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Selengkapnya
                                                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
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
