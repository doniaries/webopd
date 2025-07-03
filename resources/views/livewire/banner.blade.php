<div class="swiper" style="width:300px; height:350px; margin:auto;">
    <div class="swiper-wrapper">
        @forelse ($banners as $banner)
            <div class="swiper-slide">
                <a href="{{ $banner->url ?? '#' }}" style="width:300px; height:350px; display:block;">
                    <img src="{{ $banner->image_url }}" alt="Banner"
                        style="width:300px; height:350px; object-fit:cover; object-position:center; display:block; border:none; margin:0; padding:0; box-shadow:none; background:none;"
                        onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder2.jpg') }}'"
                        loading="lazy">
                </a>
            </div>
        @empty
            <div class="swiper-slide">
                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4 text-center" style="width:300px; height:350px;">
                    <i class="bi bi-image text-4xl mb-4"></i>
                    <p class="text-lg">Tidak ada banner tersedia</p>
                </div>
            </div>
        @endforelse
    </div>
    @if (count($banners ?? []) > 1)
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .swiper {
            width: 300px;
            height: 350px;
        }
        .swiper-slide {
            width: 300px !important;
            height: 350px !important;
        }
        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            top: 50%;
            transform: translateY(-50%);
        }
        .swiper-pagination-bullet {
            background: rgba(255,255,255,0.5);
            opacity: 1;
            width: 8px;
            height: 8px;
            margin: 0 4px !important;
            transition: all 0.3s ease;
        }
        .swiper-pagination-bullet-active {
            background: #fff;
            width: 30px;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bannerSwiper = new Swiper('.swiper', {
                loop: {{ count($banners ?? []) > 1 ? 'true' : 'false' }},
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                speed: 800,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
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
