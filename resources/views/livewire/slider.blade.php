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
        <div class="swiper main-slider group" x-ref="swiperContainer">
            <div class="swiper-wrapper">

                @foreach (array_slice($sliders, 0, 5) as $slider)
                    @php
                        $slider = is_object($slider) ? (array) $slider : $slider;
                        $imageUrl = $slider['gambar_url'] ?? 'https://source.unsplash.com/random/1600x900?abstract';
                        $title = $slider['judul'] ?? 'Judul Default Slider';
                        $url = $slider['url'] ?? '#';
                        $tags = $slider['tags'] ?? [];
                    @endphp

                    <div class="swiper-slide relative" style="height: 80vh; min-height: 500px; max-height: 800px;">
                        <img src="{{ $imageUrl }}" alt="{{ $title }}"
                            class="absolute inset-0 w-full h-full object-cover object-center z-10">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent z-20"></div>
                        <div class="relative h-full flex flex-col justify-end md:justify-center p-6 sm:p-8 md:p-12 lg:p-16 text-white z-30">
                            <div class="max-w-4xl" x-data="{ inView: false }" x-intersect:enter="inView = true" x-intersect:leave="inView = false">
                                @if (count($tags) > 0)
                                    <div class="flex flex-wrap gap-2 mb-4" x-show="inView"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0">
                                        @foreach ($tags as $tag)
                                            <a href="{{ route('post.tag', ['tag' => \Illuminate\Support\Str::slug($tag)]) }}"
                                                class="inline-block px-3 py-1 text-xs font-medium text-white bg-white/20 rounded-full backdrop-blur-sm hover:bg-white/30 transition-colors">
                                                {{ $tag }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight text-shadow"
                                    x-show="inView" x-transition:enter="transition ease-out duration-500 delay-100"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0">
                                    <a href="{{ $url }}"
                                        class="text-white no-underline hover:text-gray-200 transition">
                                        {{ $title }}
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div
                class="swiper-button-next text-white w-12 h-12 bg-black/20 rounded-full transition-all duration-300 hover:bg-black/40 opacity-0 group-hover:opacity-100 -mr-4 md:mr-2">
            </div>
            <div
                class="swiper-button-prev text-white w-12 h-12 bg-black/20 rounded-full transition-all duration-300 hover:bg-black/40 opacity-0 group-hover:opacity-100 -ml-4 md:ml-2">
            </div>

            <div class="swiper-pagination"></div>
        </div>
    @else
        <div class="bg-gray-200 h-96 flex items-center justify-center">
            <p class="text-gray-600">Slider tidak tersedia.</p>
        </div>
    @endif
</div>

{{-- Push styles and scripts are the same as before --}}
@push('styles')
    <style>
        .text-shadow {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.2s ease-out;
        }

        .swiper-pagination-bullet-active {
            width: 24px;
            border-radius: 99px;
            background-color: white;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
@endpush
