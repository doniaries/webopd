<div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide min-h-[260px] md:min-h-[400px]">
                    <div class="slide-content flex flex-col justify-center items-center h-full w-full relative">
                        @if ($slider->foto_utama_url)
                            <img src="{{ $slider->foto_utama_url }}" alt="{{ $slider->title }}" class="slide-img" />
                        @else
                            <!-- SVG Placeholder -->
                        @endif

                        <div
                            class="absolute left-1/2 top-[60%] md:top-[70%] transform -translate-x-1/2 -translate-y-1/3 w-full px-4 z-10 flex flex-col items-center pt-8 md:pt-0">
                            @if (isset($slider->tags) && count($slider->tags) > 0)
                                <div
                                    class="mb-2 flex justify-center gap-2 overflow-x-auto max-w-full bg-black/40 rounded py-1 px-2">
                                    @foreach ($slider->tags as $tag)
                                        <a href="{{ route('post.tag', ['tag' => \Illuminate\Support\Str::slug($tag->name)]) }}"
                                            class="inline-flex bg-blue-600/80 text-white text-sm font-semibold px-3 py-1 rounded-full shadow hover:bg-blue-700 transition whitespace-nowrap">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <a href="{{ route('berita.show', $slider->slug) }}">
                                <h3
                                    class="slide-title text-white text-center md:text-left ... hover:underline cursor-pointer shadow-lg">
                                    {{ $slider->title }}</h3>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <!-- Navigasi panah -->
        <div class="swiper-button-next flex items-center justify-center">
            <!-- Heroicons (outline): chevron-right -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <path d="M9 5l7 7-7 7" />
            </svg>
        </div>
        <div class="swiper-button-prev flex items-center justify-center">
            <!-- Heroicons (outline): chevron-left -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <path d="M15 19l-7-7 7-7" />
            </svg>
        </div>
        <!-- Dot pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.mySwiper', {
                loop: true,
                slidesPerView: 1,
                autoplay: {
                    delay: 5000, // 5 seconds delay
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });
        });
    </script>

    <!-- Styling tambahan agar swiper tampil bagus -->
    <style>
        .swiper {
            width: 100vw;
            height: 450px;
            min-height: 350px;
            max-height: 450px;
            background: #3a4354;
            border-radius: 0px;
            padding: 0;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw !important;
            height: 450px;
            min-height: 350px;
            max-height: 450px;
            background: transparent;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        .slide-content {
            height: 100%;
            width: 100vw;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        .slide-img {
            width: 100vw;
            height: 100%;
            min-height: 350px;
            max-height: 450px;
            object-fit: cover;
            margin: 0;
            display: block;
            border-radius: 0px;
            box-shadow: 0 2px 16px #23272f33;
            background: #4b5563;
        }

        .slide-title {
            position: relative;
            left: auto;
            top: auto;
            transform: none;
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
            width: 100%;
            text-align: center;
            text-shadow: 0 2px 8px #222;
            pointer-events: auto;
            /* background: rgba(0, 0, 0, 0.15); */
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            margin-bottom: 0;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #ffffff;
            background: rgba(17, 24, 39, 0.45); /* slate-900/45 */
            border-radius: 9999px;
            width: 44px;
            height: 44px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.25);
            border: none;
            opacity: 0.2; /* lebih transparan saat non-hover */
            transition: opacity 0.2s ease, background 0.2s ease, transform 0.2s ease;
        }

        /* Hide Swiper default double-arrow pseudo elements */
        .swiper-button-next:after,
        .swiper-button-prev:after {
            content: '' !important;
        }

        /* Ensure SVG icon is centered and inherits color */
        .swiper-button-next svg,
        .swiper-button-prev svg {
            display: block;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            opacity: 1;
            background: rgba(17, 24, 39, 0.65);
        }

        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            background: #4ea1ff;
            opacity: 1;
        }

        /* Responsive heights: Mobile 320px, Tablet 420px, Desktop 560px */
        @media (max-width: 767.98px) {
            .swiper,
            .swiper-slide {
                height: 320px;
                min-height: 320px;
                max-height: 320px;
            }
            .slide-img {
                min-height: 320px;
                max-height: 320px;
            }
        }

        @media (min-width: 768px) and (max-width: 1023.98px) {
            .swiper,
            .swiper-slide {
                height: 420px;
                min-height: 420px;
                max-height: 420px;
            }
            .slide-img {
                min-height: 420px;
                max-height: 420px;
            }
        }

        @media (min-width: 1024px) {
            .swiper,
            .swiper-slide {
                height: 560px;
                min-height: 560px;
                max-height: 560px;
            }
            .slide-img {
                min-height: 560px;
                max-height: 560px;
            }
        }
    </style>
</div>
