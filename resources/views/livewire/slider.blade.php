<div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <div class="slide-content flex flex-col justify-center items-center h-full w-full relative">
                        @if ($slider->foto_utama_url)
                            <img src="{{ $slider->foto_utama_url }}" alt="{{ $slider->title }}" class="slide-img" />
                        @else
                            <!-- SVG Placeholder -->
                        @endif
                        <h3 class="slide-title ...">{{ $slider->title }}</h3>
                        <!-- Tag -->
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($slider->tags as $tag)
                                <span
                                    class="px-3 py-1 bg-blue-200 text-blue-900 rounded-full text-xs font-semibold">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Navigasi panah -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Dot pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.mySwiper', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                slidesPerView: 1,
                spaceBetween: 24,
                // Semua breakpoint tetap 1 slide per view
                breakpoints: {
                    640: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 1
                    },
                    1024: {
                        slidesPerView: 1
                    },
                },
            });
        });
    </script>

    <!-- Styling tambahan agar swiper tampil bagus -->
    <style>
        .swiper {
            width: 100vw;
            height: 400px;
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
            width: 100vw;
            height: 400px;
            min-height: 350px;
            max-height: 450px;
            background: transparent;
            padding: 0;
            margin: 0;
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
            position: absolute;
            left: 50%;
            top: 55%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
            width: 100%;
            text-align: center;
            text-shadow: 0 2px 8px #222;
            pointer-events: none;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #4ea1ff;
            background: #fff0;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            box-shadow: none;
            border: none;
            transition: background 0.2s;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: #4ea1ff22;
        }

        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            background: #4ea1ff;
            opacity: 1;
        }
    </style>
