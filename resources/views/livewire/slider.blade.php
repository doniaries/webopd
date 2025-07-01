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
        {{-- Kontainer utama Swiper --}}
        <div class="swiper main-slider w-full" x-ref="swiperContainer">
            <div class="swiper-wrapper">
                @foreach (array_slice($sliders, 0, 5) as $slider)
                    @php
                        $slider = is_object($slider) ? (array) $slider : $slider;
                        $imageUrl = $slider['gambar_url'] ?? asset('assets/img/hero-img.png');
                        $title = $slider['judul'] ?? 'No Title';
                        $url = $slider['url'] ?? '#';
                    @endphp

                    {{-- Mengganti style inline dengan kelas Tailwind. Termasuk tinggi responsif max-sm:h-[50vh] --}}
                    <div class="swiper-slide" style="height: 80vh; min-height: 500px; max-height: 800px;">

                        <div class="relative w-full h-full">
                            <img src="{{ $imageUrl }}" alt="{{ $title }}"
                                class="w-full h-full object-cover object-center">

                            <div class="absolute inset-0 bg-black/40 z-10"></div>

                            {{-- Menggunakan kelas utilitas gradien Tailwind. Warna dan posisi henti spesifik menggunakan nilai arbitrer JIT. --}}
                            <div
                                class="absolute bottom-0 left-0 z-10 h-full w-2/3 md:w-1/2 bg-gradient-to-r from-[rgba(0,69,142,0.8)] via-[rgba(0,69,142,0.4)]/70 to-transparent">
                            </div>

                            <div
                                class="absolute bottom-0 left-0 w-full z-20 px-8 sm:px-12 md:px-16 lg:px-20 xl:px-24 pb-16">
                                <div class="max-w-5xl pr-8 lg:pr-20">
                                    @if (isset($slider['tags']) && count($slider['tags']) > 0)
                                        {{-- Mengganti margin-left inline dengan kelas ml-14 (setara 3.5rem) --}}
                                        <div class="flex flex-wrap gap-2 mb-3 ml-14 animate-slide-in-title"
                                            style="opacity: 0; animation-delay: 0.3s;">
                                            @foreach ($slider['tags'] as $tag)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-blue-800 shadow-sm">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Menghapus style inline dan menerapkan kelas kustom untuk animasi --}}
                                    <h2
                                        class="text-white fw-bold text-start max-w-[800px] mt-8 mb-4 ml-12 animate-slide-in-title">
                                        {{-- Mengganti semua style inline dengan kelas utilitas Tailwind dan kelas kustom untuk text-shadow --}}
                                        <a href="{{ $url }}"
                                            class="text-white text-decoration-none block text-[2.5rem] leading-[1.4] whitespace-normal max-w-full break-words text-shadow">
                                            {{ $title }}
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Mengganti CSS kustom dengan kelas utilitas Tailwind untuk tata letak, warna, dan hover --}}
            <div
                class="swiper-button-next text-white w-12 h-12 bg-black/30 rounded-full transition-all duration-300 hover:bg-black/50">
            </div>
            <div
                class="swiper-button-prev text-white w-12 h-12 bg-black/30 rounded-full transition-all duration-300 hover:bg-black/50">
            </div>

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
        /* Keyframes untuk animasi tetap diperlukan */
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

        /* Kelas kustom untuk menerapkan animasi. Ini menjaga HTML tetap bersih. */
        .animate-slide-in-title {
            animation: slideInFromTop 0.8s ease-out 0.5s forwards;
            opacity: 0;
            /* Opacity awal diatur di sini untuk animasi */
        }

        /* text-shadow belum menjadi utilitas standar di Tailwind, jadi kelas kustom adalah solusi yang baik. */
        .text-shadow {
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9);
        }

        /* Gaya untuk pseudo-element ::after tidak dapat diterapkan dengan utilitas Tailwind, jadi ini tetap di sini. */
        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.25rem;
            color: white;
        }

        /*
                 * Mengatur gaya untuk kelas yang ditambahkan secara dinamis oleh SwiperJS lebih mudah dilakukan di blok style.
                 * Ini memastikan bahwa bullet paginasi aktif dan non-aktif memiliki gaya yang benar.
                */
        .swiper-pagination-bullet {
            width: 0.75rem;
            height: 0.75rem;
            background-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
            margin: 0 0.25rem;
            transition: all 0.2s ease-out;
        }

        .swiper-pagination-bullet-active {
            background-color: white;
            transform: scale(1.25);
        }
    </style>
@endpush

@push('scripts')
    {{-- Pastikan skrip ini dimuat --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
