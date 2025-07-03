<div class="banner-swiper swiper" style="width:300px; height:350px; margin:auto; position:relative;">
    <div class="swiper-wrapper">
        @forelse ($banners as $banner)
            <div class="swiper-slide">
                <a href="{{ $banner->url ?? '#' }}" style="width:300px; height:350px; display:block;">
                    <img src="{{ asset('storage/' . $banner->gambar) }}" alt="Banner"
                        style="width:300px; height:350px; object-fit:cover; object-position:center; display:block;"
                        onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder2.jpg') }}'"
                        loading="lazy">
                </a>
            </div>
        @empty
            <div class="swiper-slide">
                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4 text-center"
                    style="width:300px; height:350px;">
                    <i class="bi bi-image text-4xl mb-4"></i>
                    <p class="text-lg">Tidak ada banner tersedia</p>
                </div>
            </div>
        @endforelse
    </div>
    @if (count($banners ?? []) > 1)
        <div class="swiper-button-next banner-swiper-button-next"></div>
        <div class="swiper-button-prev banner-swiper-button-prev"></div>
        <div class="swiper-pagination banner-swiper-pagination"></div>
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .banner-swiper {
            width: 300px;
            height: 350px;
            position: relative;
        }
        .banner-swiper .swiper-slide {
            width: 300px !important;
            height: 350px !important;
        }
        .banner-swiper .swiper-button-next,
        .banner-swiper .swiper-button-prev {
            color: #fff;
            background: rgba(0,0,0,0.6);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            top: 50%;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .banner-swiper .swiper-button-next { right: 10px; }
        .banner-swiper .swiper-button-prev { left: 10px; }
        .banner-swiper .swiper-pagination {
            bottom: 10px !important;
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 10;
        }
        .banner-swiper .swiper-pagination-bullet {
            background: rgba(255,255,255,0.7);
            opacity: 1;
            width: 10px;
            height: 10px;
            margin: 0 4px !important;
            transition: all 0.3s ease;
        }
        .banner-swiper .swiper-pagination-bullet-active {
            background: #ffd700;
            width: 30px;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.banner-swiper', {
            loop: {{ count($banners ?? []) > 1 ? 'true' : 'false' }},
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            pagination: {
                el: '.banner-swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.banner-swiper-button-next',
                prevEl: '.banner-swiper-button-prev',
            },
            grabCursor: true,
            preloadImages: true,
            updateOnWindowResize: true,
            watchSlidesProgress: true,
            preventClicks: true,
            preventClicksPropagation: true,
        });
    });
    </script>
@endpush
