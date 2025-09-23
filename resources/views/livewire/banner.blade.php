<div class="banner-root">
    <div class="banner-swiper swiper" style="width:300px; height:375px; margin:auto; position:relative;">
        <div class="swiper-wrapper">
            @forelse ($banners as $banner)
                <div class="swiper-slide">
                    <a href="{{ $banner->url ?? '#' }}" style="width:300px; height:375px; display:block;">
                        <img src="{{ $banner->image_url ?? asset('assets/images/placeholder2.jpg') }}" alt="Banner"
                            style="width:300px; height:375px; object-fit:contain; object-position:center; display:block; cursor: pointer; background:#fff;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder2.jpg') }}'"
                            loading="lazy" class="banner-modal-trigger"
                            data-img="{{ $banner->image_url ?? asset('assets/images/placeholder2.jpg') }}">
                    </a>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4 text-center"
                        style="width:300px; height:375px;">
                        <i class="bi bi-image text-4xl mb-4"></i>
                        <p class="text-lg">Tidak ada banner tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if (count($banners ?? []) > 1)
            <div class="swiper-button-next banner-swiper-button-next flex items-center justify-center">
                <!-- Chevron Right (outline) -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <div class="swiper-button-prev banner-swiper-button-prev flex items-center justify-center">
                <!-- Chevron Left (outline) -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <div class="swiper-pagination banner-swiper-pagination"></div>
        @endif
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <style>
            .banner-root { background: transparent !important; }

            .banner-swiper,
            .banner-swiper.swiper {
                width: 300px;
                height: 375px; /* 4:5 ratio portrait */
                position: relative;
                background: #fff !important; /* clean white background to avoid dark bars */
                padding: 0 !important;
                margin: 0 auto !important;
                overflow: hidden !important;
            }

            .banner-swiper .swiper-slide {
                width: 300px !important;
                height: 375px !important; /* 4:5 ratio */
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden !important;
            }

            /* Ensure wrapper matches fixed height */
            .banner-swiper .swiper-wrapper { height: 375px !important; background: #fff !important; }

            /* Force anchor and image to fully fill the frame */
            .banner-swiper .swiper-slide > a { display: block; width: 300px; height: 375px; background: #fff !important; }
            .banner-swiper .swiper-slide img { width: 300px; height: 375px; object-fit: contain; object-position: center; display: block; background: #fff !important; }

            /* Make pagination background transparent as well */
            .banner-swiper .swiper-pagination { background: transparent !important; }

            .banner-swiper .swiper-button-next,
            .banner-swiper .swiper-button-prev {
                color: #ffffff;
                background: rgba(17, 24, 39, 0.45); /* slate-900/45 */
                border-radius: 9999px;
                width: 40px;
                height: 40px;
                top: 50%;
                z-index: 10;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0.2; /* semi transparan default */
                pointer-events: auto; /* tetap bisa diklik */
                transition: opacity 0.2s ease, background 0.2s ease;
            }

            .banner-swiper:hover .swiper-button-next,
            .banner-swiper:hover .swiper-button-prev {
                opacity: 1;
                background: rgba(17, 24, 39, 0.65);
            }

            .banner-swiper .swiper-button-next {
                right: 10px;
            }

            .banner-swiper .swiper-button-prev {
                left: 10px;
            }

            /* Sembunyikan pseudo-element default Swiper agar tidak dobel */
            .banner-swiper .swiper-button-next:after,
            .banner-swiper .swiper-button-prev:after {
                content: '' !important;
            }

            .banner-swiper .swiper-pagination {
                bottom: 10px !important;
                left: 0;
                width: 100%;
                text-align: center;
                z-index: 10;
            }

            .banner-swiper .swiper-pagination-bullet {
                background: rgba(255, 255, 255, 0.7);
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

    <!-- Banner Modal HTML Tailwind + Zoom -->
    <div id="bannerModalBg" class="fixed inset-0 z-[99999] bg-black/60 hidden items-center justify-center overflow-visible">
        <div class="relative bg-white rounded-xl shadow-xl p-4 flex items-center justify-center max-w-[90vw] max-h-[90vh] animate-fadeIn">
            <button id="bannerModalClose" aria-label="Tutup" type="button"
                class="absolute top-3 right-3 w-9 h-9 flex items-center justify-center rounded-full bg-white text-gray-600 text-2xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Tombol Zoom -->
            <div class="absolute left-4 top-3 flex gap-2 z-10">
                <button id="bannerZoomIn" type="button" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 text-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" title="Perbesar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <button id="bannerZoomOut" type="button" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 text-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" title="Perkecil">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                    </svg>
                </button>
            </div>
            <img id="bannerModalImg" src="" alt="Preview Banner" class="max-w-xs max-h-[60vh] rounded-lg shadow-md object-contain transition-transform duration-200" style="transform: scale(1);" />
        </div>
    </div>
    <style>
      @keyframes fadeIn { from { opacity:0; transform:scale(.96);} to { opacity:1; transform:scale(1);} }
      .animate-fadeIn { animation: fadeIn 0.2s; }
      /* Fallback for modal highest z-index and overflow */
      #bannerModalBg { z-index: 99999 !important; overflow: visible !important; }
    </style> 
</div>

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
                fadeEffect: {
                    crossFade: true
                },
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
        // Modal logic (Tailwind + Zoom)
        const modalBg = document.getElementById('bannerModalBg');
        const modalImg = document.getElementById('bannerModalImg');
        const modalClose = document.getElementById('bannerModalClose');
        const zoomInBtn = document.getElementById('bannerZoomIn');
        const zoomOutBtn = document.getElementById('bannerZoomOut');
        let zoomLevel = 1;
        function applyZoom() {
            modalImg.style.transform = `scale(${zoomLevel})`;
        }
        document.querySelectorAll('.banner-modal-trigger').forEach(img => {
            img.addEventListener('click', function(e) {
                e.preventDefault();
                modalImg.src = this.getAttribute('data-img');
                zoomLevel = 1;
                applyZoom();
                modalBg.classList.remove('hidden');
                modalBg.classList.add('flex');
            });
        });
        modalClose.addEventListener('click', function() {
            modalBg.classList.add('hidden');
            modalBg.classList.remove('flex');
            modalImg.src = '';
        });
        modalBg.addEventListener('click', function(e) {
            if (e.target === modalBg) {
                modalBg.classList.add('hidden');
                modalBg.classList.remove('flex');
                modalImg.src = '';
            }
        });
        zoomInBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (zoomLevel < 3) { zoomLevel += 0.2; applyZoom(); }
        });
        zoomOutBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (zoomLevel > 0.4) { zoomLevel -= 0.2; applyZoom(); }
        });
    </script>
@endpush
